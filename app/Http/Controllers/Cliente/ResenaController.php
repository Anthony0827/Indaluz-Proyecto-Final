<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Reseña;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    /**
     * Guardar una nueva reseña
     */
    public function store(Request $request, $id_pedido)
    {
        $request->validate([
            'rating'     => 'required|numeric|between:1,5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $pedido = Pedido::with('detalles.producto')->findOrFail($id_pedido);
        $clienteId   = Auth::id();
        $agricultorId = $pedido->detalles->first()->producto->id_agricultor;

        // Prevenir reseña doble
        if (Reseña::where('id_pedido', $id_pedido)
                  ->where('id_cliente', $clienteId)
                  ->exists()) {
            return back()->with('error', 'Ya has reseñado este pedido.');
        }

        Reseña::create([
            'id_pedido'    => $id_pedido,
            'id_cliente'   => $clienteId,
            'id_agricultor'=> $agricultorId,
            'rating'       => $request->rating,
            'comentario'   => $request->comentario,
        ]);

        return back()->with('success', 'Reseña enviada correctamente.');
    }

    /**
     * Actualizar una reseña existente
     */
    public function update(Request $request, $id_pedido)
    {
        $request->validate([
            'rating'     => 'required|numeric|between:1,5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        $clienteId = Auth::id();
        $resena = Reseña::where('id_pedido',  $id_pedido)
                        ->where('id_cliente', $clienteId)
                        ->firstOrFail();

        $resena->update([
            'rating'     => $request->rating,
            'comentario' => $request->comentario,
        ]);

        return back()->with('success', 'Reseña actualizada correctamente.');
    }
}
