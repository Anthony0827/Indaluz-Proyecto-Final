<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PedidoConfirmado;

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
        // Validación de datos (mejorada para evitar errores regex)
        $validated = $request->validate([
            // Datos de envío
            'direccion_envio' => 'required|string|max:255',
            'codigo_postal' => 'required|digits:5', // Cambiado regex por digits
            'municipio' => 'required|string|max:100',
            'provincia' => 'required|string|max:100',
            'telefono_contacto' => 'required|digits_between:9,15', // Cambiado regex
            
            // Método de entrega
            'metodo_entrega' => 'required|in:recogida,domicilio',
            'fecha_entrega' => 'required|date|after_or_equal:today',
            'hora_entrega' => 'required|string',
            
            // Datos de pago - sin validaciones específicas
            'metodo_pago' => 'required|in:tarjeta,efectivo',
            'numero_tarjeta' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'nombre_titular' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'mes_expiracion' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'anio_expiracion' => 'required_if:metodo_pago,tarjeta|nullable|string',
            'cvv' => 'required_if:metodo_pago,tarjeta|nullable|string',
            
            // Notas opcionales
            'notas_cliente' => 'nullable|string|max:500',
        ], [
            'direccion_envio.required' => 'La dirección de envío es obligatoria',
            'codigo_postal.digits' => 'El código postal debe tener exactamente 5 dígitos',
            'municipio.required' => 'El municipio es obligatorio',
            'provincia.required' => 'La provincia es obligatoria',
            'telefono_contacto.digits_between' => 'El teléfono debe tener entre 9 y 15 dígitos',
            'metodo_entrega.required' => 'Selecciona un método de entrega',
            'fecha_entrega.required' => 'La fecha de entrega es obligatoria',
            'fecha_entrega.after_or_equal' => 'La fecha de entrega debe ser hoy o posterior',
            'hora_entrega.required' => 'La hora de entrega es obligatoria',
            'metodo_pago.required' => 'Selecciona un método de pago',
            'numero_tarjeta.required_if' => 'El número de tarjeta es obligatorio',
            'nombre_titular.required_if' => 'El nombre del titular es obligatorio',
            'mes_expiracion.required_if' => 'El mes de expiración es obligatorio',
            'anio_expiracion.required_if' => 'El año de expiración es obligatorio',
            'cvv.required_if' => 'El código CVV es obligatorio',
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

        // Procesar pago (simulación mejorada)
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

            // Enviar correo de confirmación
            $this->enviarCorreoConfirmacion($pedido, $productosValidados['items']);

            // Limpiar carrito
            session()->forget('carrito');

            return redirect()->route('cliente.pedido.confirmacion', $pedido->id_pedido)
                ->with('success', '¡Pedido realizado con éxito! Recibirás un correo de confirmación.');

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
     * Simula el procesamiento del pago (mejorado)
     */
    private function procesarPago($datos)
    {
        // Simulación: tanto efectivo como tarjeta son exitosos
        // Solo fallaría si la tarjeta termina en 0000 (para pruebas)
        
        if ($datos['metodo_pago'] === 'efectivo') {
            return true;
        }

        // Para tarjeta: simulamos éxito excepto si termina en 0000
        if (isset($datos['numero_tarjeta'])) {
            return !str_ends_with($datos['numero_tarjeta'], '0000');
        }

        return true; // Por defecto es exitoso
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

    /**
     * Envía el correo de confirmación del pedido
     */
    private function enviarCorreoConfirmacion($pedido, $productosCarrito)
    {
        try {
            $usuario = Auth::user();
            
            // Datos para el correo
            $datosCorreo = [
                'pedido_id' => $pedido->id_pedido,
                'cliente_nombre' => $usuario->nombre . ' ' . $usuario->apellido,
                'productos' => $productosCarrito,
                'total' => $pedido->total,
                'fecha' => $pedido->fecha_pedido->format('d/m/Y H:i')
            ];

            Mail::to($usuario->correo)->send(new PedidoConfirmado($datosCorreo));
        } catch (\Exception $e) {
            // Log del error pero no interrumpir el proceso
            \Log::error('Error enviando correo de confirmación: ' . $e->getMessage());
        }
    }
}