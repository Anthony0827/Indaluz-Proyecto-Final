<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reseña extends Model
{
    protected $table = 'reseñas';
    protected $primaryKey = 'id_reseña';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'id_agricultor',
        'id_pedido',
        'rating',
        'comentario',
        'fecha_reseña'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'fecha_reseña' => 'datetime',
    ];

    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_cliente', 'id_usuario');
    }

    /**
     * Relación con el agricultor
     */
    public function agricultor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_agricultor', 'id_usuario');
    }

    /**
     * Relación con el pedido
     */
    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Scope para reseñas positivas (4 o más estrellas)
     */
    public function scopePositivas($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Scope para reseñas con comentarios
     */
    public function scopeConComentarios($query)
    {
        return $query->whereNotNull('comentario')->where('comentario', '!=', '');
    }
}