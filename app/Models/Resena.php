<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resena extends Model
{
    protected $table = 'reseñas';
    protected $primaryKey = 'id_reseña';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente', 'id_agricultor', 'id_pedido',
        'rating', 'comentario', 'fecha_reseña'
    ];

    // Relaciones (opcional, para más funcionalidad)
    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'id_cliente', 'id_usuario');
    }

    public function agricultor()
    {
        return $this->belongsTo(Usuario::class, 'id_agricultor', 'id_usuario');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }
}
