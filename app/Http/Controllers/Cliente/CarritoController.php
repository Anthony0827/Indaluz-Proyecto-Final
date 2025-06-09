<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Muestra la vista del carrito
     */
    public function index()
    {
        // Sincronizar carrito de localStorage con sesión
        $this->sincronizarCarrito();
        
        return view('cliente.carrito');
    }

    /**
     * Valida los productos del carrito (AJAX)
     * Verifica stock disponible y precios actuales
     */
    public function validar(Request $request)
    {
        $items = $request->input('items', []);
        $productosValidados = [];
        $errores = [];
        
        foreach ($items as $item) {
            $producto = Producto::find($item['id']);
            
            if (!$producto) {
                $errores[] = "El producto '{$item['nombre']}' ya no está disponible";
                continue;
            }
            
            if ($producto->estado !== 'activo') {
                $errores[] = "El producto '{$producto->nombre}' ya no está activo";
                continue;
            }
            
            if ($producto->cantidad_inventario < $item['cantidad']) {
                $errores[] = "Stock insuficiente para '{$producto->nombre}'. Disponible: {$producto->cantidad_inventario}";
                $item['cantidad'] = $producto->cantidad_inventario;
            }
            
            // Actualizar información del producto por si cambió
            $productosValidados[] = [
                'id' => $producto->id_producto,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'precio_original' => $item['precio'] ?? $producto->precio,
                'cantidad' => min($item['cantidad'], $producto->cantidad_inventario),
                'max' => $producto->cantidad_inventario,
                'unidad' => $producto->unidad_medida_texto,
                'agricultor' => $producto->agricultor->nombre_empresa ?? $producto->agricultor->nombre,
                'imagen' => $producto->imagen ? asset('storage/' . $producto->imagen) : null,
                'precio_cambio' => $producto->precio != ($item['precio'] ?? $producto->precio)
            ];
        }
        
        // Guardar en sesión
        if (count($errores) === 0) {
            session(['carrito' => $productosValidados]);
        }
        
        return response()->json([
            'success' => count($errores) === 0,
            'productos' => $productosValidados,
            'errores' => $errores
        ]);
    }

    /**
     * Agregar producto al carrito
     */
    public function agregar(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:productos,id_producto',
            'cantidad' => 'required|integer|min:1'
        ]);

        $producto = Producto::find($validated['id']);
        
        if (!$producto->estaDisponible()) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no disponible'
            ], 400);
        }

        $carrito = session('carrito', []);
        
        // Buscar si el producto ya está en el carrito
        $encontrado = false;
        foreach ($carrito as &$item) {
            if ($item['id'] == $producto->id_producto) {
                $nuevaCantidad = $item['cantidad'] + $validated['cantidad'];
                
                if ($nuevaCantidad > $producto->cantidad_inventario) {
                    return response()->json([
                        'success' => false,
                        'message' => 'No hay suficiente stock disponible'
                    ], 400);
                }
                
                $item['cantidad'] = $nuevaCantidad;
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            $carrito[] = [
                'id' => $producto->id_producto,
                'nombre' => $producto->nombre,
                'precio' => $producto->precio,
                'cantidad' => $validated['cantidad'],
                'max' => $producto->cantidad_inventario,
                'unidad' => $producto->unidad_medida_texto,
                'agricultor' => $producto->agricultor->nombre_empresa ?? $producto->agricultor->nombre,
                'imagen' => $producto->imagen ? asset('storage/' . $producto->imagen) : null,
            ];
        }

        session(['carrito' => $carrito]);

        return response()->json([
            'success' => true,
            'message' => 'Producto agregado al carrito',
            'carrito' => $carrito
        ]);
    }

    /**
     * Actualizar cantidad de un producto
     */
    public function actualizar(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:productos,id_producto',
            'cantidad' => 'required|integer|min:0'
        ]);

        $carrito = session('carrito', []);
        
        if ($validated['cantidad'] == 0) {
            // Eliminar producto si la cantidad es 0
            $carrito = array_filter($carrito, function($item) use ($validated) {
                return $item['id'] != $validated['id'];
            });
            $carrito = array_values($carrito); // Reindexar
        } else {
            // Actualizar cantidad
            foreach ($carrito as &$item) {
                if ($item['id'] == $validated['id']) {
                    $producto = Producto::find($validated['id']);
                    
                    if ($validated['cantidad'] > $producto->cantidad_inventario) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No hay suficiente stock disponible'
                        ], 400);
                    }
                    
                    $item['cantidad'] = $validated['cantidad'];
                    break;
                }
            }
        }

        session(['carrito' => $carrito]);

        return response()->json([
            'success' => true,
            'carrito' => $carrito
        ]);
    }

    /**
     * Eliminar producto del carrito
     */
    public function eliminar(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required'
        ]);

        $carrito = session('carrito', []);
        
        $carrito = array_filter($carrito, function($item) use ($validated) {
            return $item['id'] != $validated['id'];
        });
        
        $carrito = array_values($carrito); // Reindexar
        
        session(['carrito' => $carrito]);

        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado del carrito',
            'carrito' => $carrito
        ]);
    }

    /**
     * Procesa el pedido (checkout)
     */
    public function checkout(Request $request)
    {
        return redirect()->route('cliente.checkout');
    }

    /**
     * Sincronizar carrito de localStorage con sesión
     */
    private function sincronizarCarrito()
    {
        // Este método se puede usar para sincronizar el carrito
        // entre localStorage y sesión si es necesario
        // Por ahora dejamos que JavaScript maneje localStorage
        // y PHP maneje las sesiones
    }
}