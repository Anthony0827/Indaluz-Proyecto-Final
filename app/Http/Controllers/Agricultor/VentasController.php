<?php

namespace App\Http\Controllers\Agricultor;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VentasController extends Controller
{
    /**
     * Muestra el dashboard de ventas
     */
    public function index(Request $request)
    {
        $idAgricultor = Auth::id();
        
        // Obtener período seleccionado (por defecto: último mes)
        $periodo = $request->get('periodo', 'mes');
        $fechaInicio = $this->obtenerFechaInicio($periodo);
        $fechaFin = now();

        // Si es período personalizado
        if ($periodo === 'personalizado') {
            $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : now()->subMonth();
            $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin')) : now();
        }

        // Estadísticas generales
        $estadisticas = $this->obtenerEstadisticas($idAgricultor, $fechaInicio, $fechaFin);
        
        // Productos más vendidos
        $productosMasVendidos = $this->obtenerProductosMasVendidos($idAgricultor, $fechaInicio, $fechaFin);
        
        // Ventas por día/mes
        $ventasPorPeriodo = $this->obtenerVentasPorPeriodo($idAgricultor, $fechaInicio, $fechaFin, $periodo);
        
        // Distribución por categoría
        $ventasPorCategoria = $this->obtenerVentasPorCategoria($idAgricultor, $fechaInicio, $fechaFin);
        
        // Clientes frecuentes
        $clientesFrecuentes = $this->obtenerClientesFrecuentes($idAgricultor, $fechaInicio, $fechaFin);
        
        // Comparación con período anterior
        $comparacion = $this->obtenerComparacion($idAgricultor, $fechaInicio, $fechaFin, $periodo);

        return view('agricultor.ventas.index', compact(
            'estadisticas',
            'productosMasVendidos',
            'ventasPorPeriodo',
            'ventasPorCategoria',
            'clientesFrecuentes',
            'comparacion',
            'periodo',
            'fechaInicio',
            'fechaFin'
        ));
    }

    /**
     * Exportar reporte de ventas
     */
    public function exportar(Request $request)
    {
        // Aquí podrías implementar la exportación a PDF o Excel
        // Por ahora retornamos un mensaje
        return back()->with('info', 'Función de exportación próximamente disponible');
    }

    /**
     * Obtener estadísticas generales
     */
    private function obtenerEstadisticas($idAgricultor, $fechaInicio, $fechaFin)
    {
        $query = DB::table('pedidos')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin]);

        // Total de ventas
        $totalVentas = (clone $query)->sum(DB::raw('detalle_pedido.cantidad * detalle_pedido.precio_unitario'));

        // Número de pedidos
        $numeroPedidos = (clone $query)->distinct('pedidos.id_pedido')->count('pedidos.id_pedido');

        // Productos vendidos
        $productosVendidos = (clone $query)->sum('detalle_pedido.cantidad');

        // Ticket medio
        $ticketMedio = $numeroPedidos > 0 ? $totalVentas / $numeroPedidos : 0;

        // Clientes únicos
        $clientesUnicos = (clone $query)->distinct('pedidos.id_cliente')->count('pedidos.id_cliente');

        // Producto estrella
        $productoEstrella = DB::table('productos')
            ->select('productos.nombre', DB::raw('SUM(detalle_pedido.cantidad) as total_vendido'))
            ->join('detalle_pedido', 'productos.id_producto', '=', 'detalle_pedido.id_producto')
            ->join('pedidos', 'detalle_pedido.id_pedido', '=', 'pedidos.id_pedido')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin])
            ->groupBy('productos.id_producto', 'productos.nombre')
            ->orderBy('total_vendido', 'desc')
            ->first();

        return [
            'total_ventas' => $totalVentas,
            'numero_pedidos' => $numeroPedidos,
            'productos_vendidos' => $productosVendidos,
            'ticket_medio' => $ticketMedio,
            'clientes_unicos' => $clientesUnicos,
            'producto_estrella' => $productoEstrella
        ];
    }

    /**
     * Obtener productos más vendidos
     */
    private function obtenerProductosMasVendidos($idAgricultor, $fechaInicio, $fechaFin, $limite = 10)
    {
        return DB::table('productos')
            ->select(
                'productos.id_producto',
                'productos.nombre',
                'productos.categoria',
                'productos.precio',
                DB::raw('SUM(detalle_pedido.cantidad) as cantidad_vendida'),
                DB::raw('SUM(detalle_pedido.cantidad * detalle_pedido.precio_unitario) as ingresos'),
                DB::raw('COUNT(DISTINCT pedidos.id_pedido) as numero_pedidos')
            )
            ->join('detalle_pedido', 'productos.id_producto', '=', 'detalle_pedido.id_producto')
            ->join('pedidos', 'detalle_pedido.id_pedido', '=', 'pedidos.id_pedido')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin])
            ->groupBy('productos.id_producto', 'productos.nombre', 'productos.categoria', 'productos.precio')
            ->orderBy('ingresos', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Obtener ventas por período
     */
    private function obtenerVentasPorPeriodo($idAgricultor, $fechaInicio, $fechaFin, $periodo)
    {
        $groupBy = match($periodo) {
            'semana', 'mes' => 'DATE(pedidos.fecha_pedido)',
            'trimestre', 'anio' => 'MONTH(pedidos.fecha_pedido)',
            default => 'DATE(pedidos.fecha_pedido)'
        };

        return DB::table('pedidos')
            ->select(
                DB::raw($groupBy . ' as fecha'),
                DB::raw('SUM(detalle_pedido.cantidad * detalle_pedido.precio_unitario) as total'),
                DB::raw('COUNT(DISTINCT pedidos.id_pedido) as numero_pedidos')
            )
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin])
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();
    }

    /**
     * Obtener ventas por categoría
     */
    private function obtenerVentasPorCategoria($idAgricultor, $fechaInicio, $fechaFin)
    {
        return DB::table('productos')
            ->select(
                'productos.categoria',
                DB::raw('SUM(detalle_pedido.cantidad) as cantidad'),
                DB::raw('SUM(detalle_pedido.cantidad * detalle_pedido.precio_unitario) as total')
            )
            ->join('detalle_pedido', 'productos.id_producto', '=', 'detalle_pedido.id_producto')
            ->join('pedidos', 'detalle_pedido.id_pedido', '=', 'pedidos.id_pedido')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin])
            ->groupBy('productos.categoria')
            ->get();
    }

    /**
     * Obtener clientes frecuentes
     */
    private function obtenerClientesFrecuentes($idAgricultor, $fechaInicio, $fechaFin, $limite = 5)
    {
        return DB::table('usuarios')
            ->select(
                'usuarios.id_usuario',
                'usuarios.nombre',
                'usuarios.apellido',
                DB::raw('COUNT(DISTINCT pedidos.id_pedido) as numero_pedidos'),
                DB::raw('SUM(detalle_pedido.cantidad * detalle_pedido.precio_unitario) as total_comprado'),
                DB::raw('MAX(pedidos.fecha_pedido) as ultima_compra')
            )
            ->join('pedidos', 'usuarios.id_usuario', '=', 'pedidos.id_cliente')
            ->join('detalle_pedido', 'pedidos.id_pedido', '=', 'detalle_pedido.id_pedido')
            ->join('productos', 'detalle_pedido.id_producto', '=', 'productos.id_producto')
            ->where('productos.id_agricultor', $idAgricultor)
            ->where('pedidos.estado', 'entregado')
            ->whereBetween('pedidos.fecha_pedido', [$fechaInicio, $fechaFin])
            ->groupBy('usuarios.id_usuario', 'usuarios.nombre', 'usuarios.apellido')
            ->orderBy('total_comprado', 'desc')
            ->limit($limite)
            ->get();
    }

    /**
     * Obtener comparación con período anterior
     */
    private function obtenerComparacion($idAgricultor, $fechaInicio, $fechaFin, $periodo)
    {
        $diasDiferencia = $fechaInicio->diffInDays($fechaFin);
        $fechaInicioAnterior = (clone $fechaInicio)->subDays($diasDiferencia);
        $fechaFinAnterior = (clone $fechaInicio)->subDay();

        // Estadísticas período actual
        $actualStats = $this->obtenerEstadisticas($idAgricultor, $fechaInicio, $fechaFin);
        
        // Estadísticas período anterior
        $anteriorStats = $this->obtenerEstadisticas($idAgricultor, $fechaInicioAnterior, $fechaFinAnterior);

        // Calcular porcentajes de cambio
        $comparacion = [
            'ventas' => $this->calcularPorcentajeCambio($actualStats['total_ventas'], $anteriorStats['total_ventas']),
            'pedidos' => $this->calcularPorcentajeCambio($actualStats['numero_pedidos'], $anteriorStats['numero_pedidos']),
            'productos' => $this->calcularPorcentajeCambio($actualStats['productos_vendidos'], $anteriorStats['productos_vendidos']),
            'ticket_medio' => $this->calcularPorcentajeCambio($actualStats['ticket_medio'], $anteriorStats['ticket_medio']),
            'clientes' => $this->calcularPorcentajeCambio($actualStats['clientes_unicos'], $anteriorStats['clientes_unicos']),
        ];

        return $comparacion;
    }

    /**
     * Calcular porcentaje de cambio
     */
    private function calcularPorcentajeCambio($valorActual, $valorAnterior)
    {
        if ($valorAnterior == 0) {
            return $valorActual > 0 ? 100 : 0;
        }

        return round((($valorActual - $valorAnterior) / $valorAnterior) * 100, 1);
    }

    /**
     * Obtener fecha de inicio según el período
     */
    private function obtenerFechaInicio($periodo)
    {
        return match($periodo) {
            'hoy' => now()->startOfDay(),
            'semana' => now()->startOfWeek(),
            'mes' => now()->startOfMonth(),
            'trimestre' => now()->startOfQuarter(),
            'anio' => now()->startOfYear(),
            default => now()->subMonth()
        };
    }
}