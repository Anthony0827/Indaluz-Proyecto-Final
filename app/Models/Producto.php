<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    public $timestamps = false;

    protected $fillable = [
        'id_agricultor',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'tiempo_de_cosecha',
        'cantidad_inventario',
        'categoria',
        'estado'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'cantidad_inventario' => 'integer',
    ];

    /**
     * Relación con el agricultor
     */
    public function agricultor(): BelongsTo
    {
        return $this->belongsTo(Usuario::class, 'id_agricultor', 'id_usuario');
    }

    /**
     * Relación con los detalles de pedido
     */
    public function detallesPedido(): HasMany
    {
        return $this->hasMany(DetallePedido::class, 'id_producto', 'id_producto');
    }

    /**
     * Scope para productos activos
     */
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    /**
     * Scope para productos con stock
     */
    public function scopeConStock($query)
    {
        return $query->where('cantidad_inventario', '>', 0);
    }

    /**
     * Verifica si el producto está disponible
     */
    public function estaDisponible(): bool
    {
        return $this->estado === 'activo' && $this->cantidad_inventario > 0;
    }

    /**
     * Obtiene la URL de la imagen o una por defecto
     */
    public function getImagenUrlAttribute(): string
    {
        if ($this->imagen) {
            return asset('storage/' . $this->imagen);
        }
        
        // Imagen por defecto según categoría
        $defaultImage = $this->categoria === 'fruta' ? 'default-fruta.jpg' : 'default-verdura.jpg';
        return asset('images/' . $defaultImage);
    }
}