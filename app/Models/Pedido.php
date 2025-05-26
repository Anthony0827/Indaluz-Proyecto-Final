<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'fecha_pedido',
        'total',
        'estado',
        'direccion_envio'
    ];

    protected $casts = [
        'fecha_pedido' => 'datetime',
        'total' => 'decimal:2',
    ];

    /**
     * Relación con el cliente
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_cliente', 'id_usuario');
    }

    /**
     * Relación con los detalles del pedido
     */
    public function detalles(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Relación con las reseñas
     */
    public function resenas(): HasMany
    {
        return $this->hasMany(Reseña::class, 'id_pedido', 'id_pedido');
    }

    /**
     * Scope para pedidos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para pedidos completados
     */
    public function scopeCompletados($query)
    {
        return $query->where('estado', 'entregado');
    }
}