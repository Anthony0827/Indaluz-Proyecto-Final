<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Mostrar lista de pedidos del cliente autenticado
     */
    public function index()
    {
        // ID del cliente logueado
        $clienteId = Auth::id();

        // Traer pedidos con sus detalles y producto relacionado,
        // ordenados por fecha de pedido descendente y paginados
        $pedidos = Pedido::with(['detalles.producto'])
                    ->where('id_cliente', $clienteId)
                    ->orderBy('fecha_pedido', 'desc')
                    ->paginate(10);

        return view('cliente.pedidos.index', compact('pedidos'));
    }

    /**
     * (Opcional) Mostrar detalle de un pedido concreto
     */
    public function show($id)
    {
        // Asegurarse de que el pedido pertenece al cliente
        $pedido = Pedido::with(['detalles.producto'])
                    ->where('id_pedido', $id)
                    ->where('id_cliente', Auth::id())
                    ->firstOrFail();

        return view('cliente.pedidos.show', compact('pedido'));
    }
}
