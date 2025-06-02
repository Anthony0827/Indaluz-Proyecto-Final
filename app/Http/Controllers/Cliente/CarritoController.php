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
        
        return response()->json([
            'success' => count($errores) === 0,
            'productos' => $productosValidados,
            'errores' => $errores
        ]);
    }

    /**
     * Procesa el pedido (checkout)
     */
    public function checkout(Request $request)
    {
        // Por ahora solo redirigimos a la vista de checkout
        // Aquí implementaremos el proceso de pago después
        return redirect()->route('cliente.checkout');
    }
}