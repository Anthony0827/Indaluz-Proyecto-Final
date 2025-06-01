<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Muestra la página principal del cliente con:
     *  - La lista paginada de productos ($productos)
     *  - Los productos recientes destacados ($productosRecientes)
     *  - Los agricultores destacados ($agricultoresDestacados)
     */
    public function home(Request $request)
    {
        // 1) Consulta principal: productos activos con stock
        $query = Producto::with('agricultor')
            ->activos()
            ->conStock();

        // 1.a) Filtro por búsqueda de texto (nombre o descripción)
        if ($request->filled('buscar')) {
            $buscar = $request->get('buscar');
            $query->where(function($q) use ($buscar) {
                $q->where('nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('descripcion', 'LIKE', "%{$buscar}%");
            });
        }

        // 1.b) Filtro por categoría (fruta, verdura…)
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->get('categoria'));
        }

        // 1.c) Filtro por precio máximo
        if ($request->filled('precio_max')) {
            $query->where('precio', '<=', $request->get('precio_max'));
        }

        // 1.d) Filtro por frescura (hoy, semana)
        if ($request->filled('frescura')) {
            $frescura = $request->get('frescura');
            if ($frescura === 'hoy') {
                $query->where('tiempo_de_cosecha', 'Recién cosechado');
            } elseif ($frescura === 'semana') {
                $query->whereIn('tiempo_de_cosecha', [
                    'Recién cosechado',
                    '1 día',
                    '2-3 días',
                    '4-7 días',
                ]);
            }
        }

        // 1.e) Ordenamiento
        $orden = $request->get('orden', 'recientes');
        switch ($orden) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'nombre':
                $query->orderBy('nombre', 'asc');
                break;
            default:
                // “recientes” → por id_producto descendente
                $query->orderBy('id_producto', 'desc');
                break;
        }

        // 1.f) Paginación (12 por página)
        $productos = $query->paginate(12);
        $productos->appends($request->all());


        // 2) Productos recientes (los 4 últimos productos activos con stock), usando id_producto
        $productosRecientes = Producto::with('agricultor')
            ->activos()
            ->conStock()
            ->orderBy('id_producto', 'desc')
            ->limit(4)
            ->get();


        // 3) Agricultores destacados (los 6 que tengan más productos activos con stock)
        $agricultoresDestacados = Usuario::where('rol', 'agricultor')
            ->withCount(['productos' => function($q) {
                $q->activos()->conStock();
            }])
            ->orderBy('productos_count', 'desc')
            ->limit(6)
            ->get();

        // 4) Pasamos todo a la vista
        return view('cliente.home', compact(
            'productos',
            'productosRecientes',
            'agricultoresDestacados'
        ));
    }

    /**
     * Muestra el detalle de un producto
     */
    public function producto($id)
    {
        $producto = Producto::with([
                'agricultor',
                'agricultor.productos' => function($query) use ($id) {
                    $query->where('id_producto', '!=', $id)
                          ->where('estado', 'activo')
                          ->where('cantidad_inventario', '>', 0)
                          ->limit(4);
                }
            ])->findOrFail($id);

        // Si el producto no está activo o no tiene stock, redirige al catálogo
        if ($producto->estado !== 'activo' || $producto->cantidad_inventario <= 0) {
            return redirect()->route('cliente.catalogo')
                             ->with('error', 'Este producto no está disponible');
        }

        // Productos similares (misma categoría)
        $similares = Producto::with('agricultor')
            ->where('id_producto', '!=', $id)
            ->where('categoria', $producto->categoria)
            ->activos()
            ->conStock()
            ->limit(4)
            ->inRandomOrder()
            ->get();

        return view('cliente.producto', compact('producto', 'similares'));
    }

    /**
     * Muestra el perfil público de un agricultor
     */
    public function agricultor($id)
    {
        $agricultor = Usuario::where('rol', 'agricultor')
            ->where('id_usuario', $id)
            ->firstOrFail();

        // Productos del agricultor
        $productos = $agricultor->productos()
            ->activos()
            ->conStock()
            ->paginate(12);

        // Estadísticas básicas
        $totalProductos = $agricultor->productos()->activos()->count();
        $calificacionPromedio = $agricultor->reseñasRecibidas()->avg('rating') ?? 0;
        $totalReseñas = $agricultor->reseñasRecibidas()->count();

        // Reseñas recientes
        $reseñasRecientes = $agricultor->reseñasRecibidas()
            ->with('cliente')
            ->orderBy('fecha_reseña', 'desc')
            ->limit(5)
            ->get();

        return view('cliente.agricultor', compact(
            'agricultor',
            'productos',
            'totalProductos',
            'calificacionPromedio',
            'totalReseñas',
            'reseñasRecientes'
        ));
    }
}
