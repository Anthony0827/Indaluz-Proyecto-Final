<?php

namespace App\Http\Controllers\Agricultor;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PedidosController extends Controller
{
    /**
     * Muestra la lista de pedidos del agricultor
     */
    public function index(Request $request)
    {
        $idAgricultor = Auth::id();
        
        // Query base: pedidos que contienen productos del agricultor
        $query = DB::table('pedidos')
            ->select(
                'pedidos.*',
                'usuarios.nombre as cliente_nombre',
                'usuarios.apellido as cliente_apellido',
                'usuarios.telefono as cliente_telefono',
                'usuarios.correo as cliente_correo',
                DB::raw('SUM(CASE WHEN productos.id_agricultor = ' . $idAgricultor . ' THEN detalle_pedido.cantidad * detalle_pedido.precio_unitario ELSE 0 END) as total_agricultor'),
                DB::raw('COUNT(DISTINCT CASE WHEN productos.id_agricultor = ' . $idAgricultor . ' THEN detalle_pedido.id_detalle END) as productos_agricultor')
            )
            ->join('usuarios', 'pedidos.id_cliente', '=', 'usuarios.id_usuario')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->whereExists(function($q) use ($idAgricultor) {
                $q->select(DB::raw(1))
                  ->from('detalle_pedido as dp')
                  ->join('productos as p', 'dp.id_producto', '=', 'p.id_producto')
                  ->whereRaw('dp.id_pedido = pedidos.id_pedido')
                  ->where('p.id_agricultor', $idAgricultor);
            })
            ->groupBy('pedidos.id_pedido', 'usuarios.nombre', 'usuarios.apellido', 'usuarios.telefono', 'usuarios.correo');

        // Filtros
        if ($request->filled('estado')) {
            $query->where('pedidos.estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('usuarios.nombre', 'LIKE', "%{$buscar}%")
                  ->orWhere('usuarios.apellido', 'LIKE', "%{$buscar}%")
                  ->orWhere('pedidos.id_pedido', 'LIKE', "%{$buscar}%");
            });
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('pedidos.fecha_pedido', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('pedidos.fecha_pedido', '<=', $request->fecha_hasta);
        }

        // Ordenamiento
        $query->orderBy('pedidos.fecha_pedido', 'desc');

        // Paginación
        $pedidos = $query->paginate(15);
        
        // Estadísticas
        $estadisticas = $this->obtenerEstadisticas($idAgricultor);

        return view('agricultor.pedidos.index', compact('pedidos', 'estadisticas'));
    }

    /**
     * Muestra el detalle de un pedido
     */
    public function show($id)
    {
        $idAgricultor = Auth::id();
        
        // Obtener el pedido
        $pedido = Pedido::with(['cliente', 'detalles.producto'])
            ->where('id_pedido', $id)
            ->firstOrFail();
        
        // Verificar que el pedido contenga productos del agricultor
        $productosDelAgricultor = $pedido->detalles->filter(function($detalle) use ($idAgricultor) {
            return $detalle->producto->id_agricultor == $idAgricultor;
        });
        
        if ($productosDelAgricultor->isEmpty()) {
            abort(403, 'No tienes acceso a este pedido');
        }
        
        // Calcular totales del agricultor
        $totalAgricultor = $productosDelAgricultor->sum(function($detalle) {
            return $detalle->cantidad * $detalle->precio_unitario;
        });

        return view('agricultor.pedidos.show', compact('pedido', 'productosDelAgricultor', 'totalAgricultor'));
    }

    /**
     * Actualiza el estado de un pedido
     */
    public function updateEstado(Request $request, $id)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,confirmado,cancelado,entregado'
        ]);

        $idAgricultor = Auth::id();
        
        // Verificar que el pedido contenga productos del agricultor
        $pedido = Pedido::where('id_pedido', $id)
            ->whereExists(function($q) use ($idAgricultor) {
                $q->select(DB::raw(1))
                  ->from('detalle_pedido')
                  ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
                  ->whereRaw('detalle_pedido.id_pedido = pedidos.id_pedido')
                  ->where('productos.id_agricultor', $idAgricultor);
            })
            ->firstOrFail();

        // Actualizar estado
        $pedido->update(['estado' => $validated['estado']]);

        // Si se cancela, devolver stock
        if ($validated['estado'] === 'cancelado') {
            $detalles = DetallePedido::where('id_pedido', $id)
                ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
                ->where('productos.id_agricultor', $idAgricultor)
                ->get();
            
            foreach ($detalles as $detalle) {
                $detalle->producto->increment('cantidad_inventario', $detalle->cantidad);
            }
        }

        return redirect()->route('agricultor.pedidos.show', $id)
            ->with('success', 'Estado del pedido actualizado correctamente');
    }

    /**
     * Marcar productos como preparados
     */
    public function marcarPreparado($id)
    {
        $idAgricultor = Auth::id();
        
        // Aquí podrías implementar un sistema más complejo
        // Por ahora, solo confirmamos que el agricultor ha preparado sus productos
        
        return redirect()->route('agricultor.pedidos.show', $id)
            ->with('success', 'Productos marcados como preparados');
    }

    /**
     * Obtener estadísticas de pedidos
     */
    private function obtenerEstadisticas($idAgricultor)
    {
        $baseQuery = DB::table('pedidos')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->where('productos.id_agricultor', $idAgricultor);

        return [
            'pendientes' => (clone $baseQuery)->where('pedidos.estado', 'pendiente')->distinct('pedidos.id_pedido')->count('pedidos.id_pedido'),
            'confirmados' => (clone $baseQuery)->where('pedidos.estado', 'confirmado')->distinct('pedidos.id_pedido')->count('pedidos.id_pedido'),
            'entregados' => (clone $baseQuery)->where('pedidos.estado', 'entregado')->distinct('pedidos.id_pedido')->count('pedidos.id_pedido'),
            'cancelados' => (clone $baseQuery)->where('pedidos.estado', 'cancelado')->distinct('pedidos.id_pedido')->count('pedidos.id_pedido'),
        ];
    }

    /**
     * Exportar pedidos
     */
    public function exportar(Request $request)
    {
        // Implementación futura para exportar a PDF/Excel
        return back()->with('info', 'Función de exportación próximamente disponible');
    }
}