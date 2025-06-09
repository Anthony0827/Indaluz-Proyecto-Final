<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Muestra el formulario de checkout
     */
    public function index()
    {
        // Obtener items del carrito desde la sesión o localStorage
        $carrito = session('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('cliente.carrito')
                ->with('error', 'Tu carrito está vacío');
        }

        // Validar disponibilidad de productos
        $productosValidados = $this->validarProductos($carrito);
        
        if (!$productosValidados['valido']) {
            return redirect()->route('cliente.carrito')
                ->with('error', 'Algunos productos ya no están disponibles');
        }

        $cliente = Auth::user();
        $items = $productosValidados['items'];
        $subtotal = $productosValidados['subtotal'];

        return view('cliente.checkout', compact('cliente', 'items', 'subtotal'));
    }

    /**
     * Procesa el pedido
     */
    public function procesar(Request $request)
    {
        // Validación de datos
        $validated = $request->validate([
            // Datos de envío
            'direccion_envio' => 'required|string|max:255',
            'codigo_postal' => 'required|regex:/^[0-9]{5}$/',
            'municipio' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'telefono_contacto' => 'required|regex:/^[0-9]{9,}$/',
            
            // Método de entrega
            'metodo_entrega' => 'required|in:recogida,domicilio',
            'fecha_entrega' => 'required|date|after_or_equal:today',
            'hora_entrega' => 'required|string',
            
            // Datos de pago
            'metodo_pago' => 'required|in:tarjeta,efectivo',
            'numero_tarjeta' => 'required_if:metodo_pago,tarjeta|nullable|regex:/^[0-9]{16}$/',
            'nombre_titular' => 'required_if:metodo_pago,tarjeta|nullable|string|max:100',
            'mes_expiracion' => 'required_if:metodo_pago,tarjeta|nullable|regex:/^(0[1-9]|1[0-2])$/',
            'anio_expiracion' => 'required_if:metodo_pago,tarjeta|nullable|regex:/^[0-9]{2}$/',
            'cvv' => 'required_if:metodo_pago,tarjeta|nullable|regex:/^[0-9]{3,4}$/',
            
            // Notas opcionales
            'notas_cliente' => 'nullable|string|max:500',
        ], [
            'direccion_envio.required' => 'La dirección de envío es obligatoria',
            'codigo_postal.regex' => 'El código postal debe tener 5 dígitos',
            'telefono_contacto.regex' => 'El teléfono debe tener al menos 9 dígitos',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega debe ser hoy o posterior',
            'numero_tarjeta.regex' => 'El número de tarjeta debe tener 16 dígitos',
            'cvv.regex' => 'El CVV debe tener 3 o 4 dígitos',
        ]);

        // Obtener carrito
        $carrito = session('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('cliente.carrito')
                ->with('error', 'Tu carrito está vacío');
        }

        // Validar productos nuevamente
        $productosValidados = $this->validarProductos($carrito);
        
        if (!$productosValidados['valido']) {
            return redirect()->route('cliente.carrito')
                ->with('error', 'Algunos productos ya no están disponibles');
        }

        // Procesar pago (simulación)
        $pagoAprobado = $this->procesarPago($validated);
        
        if (!$pagoAprobado) {
            return back()->with('error', 'Error al procesar el pago. Por favor, verifica los datos de tu tarjeta.');
        }

        // Crear pedido en base de datos
        DB::beginTransaction();
        
        try {
            // Crear pedido principal
            $pedido = Pedido::create([
                'id_cliente' => Auth::id(),
                'fecha_pedido' => now(),
                'total' => $productosValidados['subtotal'],
                'estado' => 'confirmado',
                'metodo_pago' => $validated['metodo_pago'],
                'metodo_entrega' => $validated['metodo_entrega'],
                'fecha_entrega' => $validated['fecha_entrega'],
                'hora_entrega' => $validated['hora_entrega'],
                'notas_cliente' => $validated['notas_cliente'] ?? null,
                'direccion_envio' => $this->formatearDireccion($validated),
                'numero_transaccion' => $this->generarNumeroTransaccion(),
                'estado_pago' => 'pagado',
            ]);

            // Crear detalles del pedido y actualizar inventario
            foreach ($productosValidados['items'] as $item) {
                // Crear detalle
                DetallePedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_producto' => $item['producto']->id_producto,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['producto']->precio,
                ]);

                // Actualizar inventario
                $item['producto']->decrement('cantidad_inventario', $item['cantidad']);
            }

            DB::commit();

            // Limpiar carrito
            session()->forget('carrito');

            // Enviar notificaciones (aquí podrías enviar emails)
            // $this->enviarNotificaciones($pedido);

            return redirect()->route('cliente.pedido.confirmacion', $pedido->id_pedido)
                ->with('success', '¡Pedido realizado con éxito!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->with('error', 'Error al procesar el pedido. Por favor, intenta nuevamente.');
        }
    }

    /**
     * Muestra la confirmación del pedido
     */
    public function confirmacion($id)
    {
        $pedido = Pedido::with(['detalles.producto.agricultor'])
            ->where('id_cliente', Auth::id())
            ->where('id_pedido', $id)
            ->firstOrFail();

        return view('cliente.pedido-confirmacion', compact('pedido'));
    }

    /**
     * Valida la disponibilidad de los productos
     */
    private function validarProductos($carrito)
    {
        $items = [];
        $subtotal = 0;
        $valido = true;

        foreach ($carrito as $item) {
            $producto = Producto::find($item['id']);
            
            if (!$producto || $producto->estado !== 'activo' || $producto->cantidad_inventario < $item['cantidad']) {
                $valido = false;
                break;
            }

            $items[] = [
                'producto' => $producto,
                'cantidad' => $item['cantidad'],
                'subtotal' => $producto->precio * $item['cantidad'],
            ];

            $subtotal += $producto->precio * $item['cantidad'];
        }

        return [
            'valido' => $valido,
            'items' => $items,
            'subtotal' => $subtotal,
        ];
    }

    /**
     * Simula el procesamiento del pago
     */
    private function procesarPago($datos)
    {
        // En producción, aquí integrarías con una pasarela de pago real
        // Por ahora, simulamos que el pago es exitoso si:
        // - El método es efectivo, o
        // - La tarjeta no termina en 0000
        
        if ($datos['metodo_pago'] === 'efectivo') {
            return true;
        }

        // Simulación simple: rechazar si la tarjeta termina en 0000
        return !str_ends_with($datos['numero_tarjeta'], '0000');
    }

    /**
     * Formatea la dirección completa
     */
    private function formatearDireccion($datos)
    {
        return $datos['direccion_envio'] . ', ' . 
               $datos['codigo_postal'] . ' ' . 
               $datos['municipio'] . ', ' . 
               $datos['provincia'];
    }

    /**
     * Genera un número de transacción único
     */
    private function generarNumeroTransaccion()
    {
        return 'TRX-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
    }
}