<?php

namespace App\Http\Controllers\Agricultor;

use App\Http\Controllers\Controller;
use App\Models\Reseña;
use Illuminate\Support\Facades\Auth;

class ResenasController extends Controller
{
    /**
     * Muestra el listado de reseñas para el agricultor autenticado.
     */
    public function index()
    {
        $agricultorId = Auth::id();

        // Traer reseñas del agricultor con datos de cliente y pedido
        $resenas = Reseña::with(['cliente', 'pedido'])
                    ->where('id_agricultor', $agricultorId)
                    ->orderBy('fecha_reseña', 'desc')
                    ->paginate(10);

        return view('agricultor.resenas.index', compact('resenas'));
    }
}
