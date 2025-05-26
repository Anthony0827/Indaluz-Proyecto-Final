<?php

namespace App\Http\Controllers\Agricultor;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Reseña;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AgricultorController extends Controller
{
    /**
     * Muestra el dashboard principal del agricultor
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Obtener estadísticas básicas
        $stats = $this->getEstadisticas($user->id_usuario);
        
        // Productos más vendidos
        $topProductos = $this->getTopProductos($user->id_usuario, 5);
        
        // Pedidos recientes
        $pedidosRecientes = $this->getPedidosRecientes($user->id_usuario, 5);

        return view('agricultor.dashboard', compact('stats', 'topProductos', 'pedidosRecientes'));
    }

    /**
     * Obtiene estadísticas generales del agricultor
     */
    private function getEstadisticas($idAgricultor)
    {
        // Total de productos activos
        $productosActivos = Producto::where('id_agricultor', $idAgricultor)
            ->where('estado', 'activo')
            ->count();

        // Total de pedidos este mes
        $pedidosMes = DB::table('pedidos')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->where('productos.id_agricultor', $idAgricultor)
            ->whereMonth('pedidos.fecha_pedido', date('m'))
            ->whereYear('pedidos.fecha_pedido', date('Y'))
            ->count();

        // Ingresos del mes
        $ingresosMes = DB::table('pedidos')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereMonth('pedidos.fecha_pedido', date('m'))
            ->whereYear('pedidos.fecha_pedido', date('Y'))
            ->sum(DB::raw('detalle_pedido.cantidad * detalle_pedido.precio_unitario'));

        // Calificación promedio
        $calificacionPromedio = Reseña::where('id_agricultor', $idAgricultor)
            ->avg('rating') ?? 0;

        return [
            'productos_activos' => $productosActivos,
            'pedidos_mes' => $pedidosMes,
            'ingresos_mes' => $ingresosMes,
            'calificacion_promedio' => round($calificacionPromedio, 1)
        ];
    }

    /**
     * Obtiene los productos más vendidos
     */
    private function getTopProductos($idAgricultor, $limite = 5)
    {
        return DB::table('productos')
            ->select('productos.*', DB::raw('SUM(detalle_pedido.cantidad) as total_vendido'))
            ->join('detalle_pedido', 'productos.id_producto', '=', 'detalle_pedido.id_producto')
            ->join('pedidos', 'detalle_pedido.id_pedido', '=', 'pedidos.id_pedido')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->groupBy('productos.id_producto')
            ->orderBy('total_vendido', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Obtiene los pedidos más recientes
     */
    private function getPedidosRecientes($idAgricultor, $limite = 5)
    {
        return DB::table('pedidos')
            ->select('pedidos.*', 'usuarios.nombre', 'usuarios.apellido')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->join('usuarios', 'pedidos.id_cliente', '=', 'usuarios.id_usuario')
            ->where('productos.id_agricultor', $idAgricultor)
            ->groupBy('pedidos.id_pedido')
            ->orderBy('pedidos.fecha_pedido', 'desc')
            ->limit($limite)
            ->get();
    }
}