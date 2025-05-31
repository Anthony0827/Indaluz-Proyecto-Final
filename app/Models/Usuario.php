<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contraseña',
        'direccion',
        'codigo_postal',
        'municipio',
        'provincia',
        'telefono',
        'rol',
        'nombre_empresa',
        'descripcion_publica',
        'anos_experiencia',
        'certificaciones',
        'metodos_cultivo',
        'horario_atencion',
        'foto_perfil',
        'foto_portada',
        'verificado',
    ];

    protected $hidden = [
        'contraseña',
    ];

    protected $casts = [
        'anos_experiencia' => 'integer',
        'verificado' => 'boolean',
    ];

    // Para que Auth use 'contraseña' en lugar de 'password'
    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    /**
     * Relación con productos (para agricultores)
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_agricultor', 'id_usuario');
    }

    /**
     * Relación con reseñas recibidas (para agricultores)
     */
    public function reseñasRecibidas()
    {
        return $this->hasMany(Reseña::class, 'id_agricultor', 'id_usuario');
    }

    /**
     * Relación con reseñas escritas (para clientes)
     */
    public function reseñasEscritas()
    {
        return $this->hasMany(Reseña::class, 'id_cliente', 'id_usuario');
    }

    /**
     * Relación con pedidos (para clientes)
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_cliente', 'id_usuario');
    }

    /**
     * Relación con verificaciones
     */
    public function verificaciones()
    {
        return $this->hasMany(Verificacion::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Obtener URL de la foto de perfil
     */
    public function getFotoPerfilUrlAttribute()
    {
        if ($this->foto_perfil) {
            return asset('storage/' . $this->foto_perfil);
        }
        
        // Avatar por defecto con inicial
        return null;
    }

    /**
     * Obtener URL de la foto de portada
     */
    public function getFotoPortadaUrlAttribute()
    {
        if ($this->foto_portada) {
            return asset('storage/' . $this->foto_portada);
        }
        
        // Imagen de portada por defecto
        return asset('images/portada-default.jpg');
    }

    /**
     * Scope para filtrar por rol
     */
    public function scopeRol($query, $rol)
    {
        return $query->where('rol', $rol);
    }

    /**
     * Scope para usuarios verificados
     */
    public function scopeVerificados($query)
    {
        return $query->where('verificado', 1);
    }

    /**
     * Verifica si el usuario es administrador
     */
    public function esAdministrador()
    {
        return $this->rol === 'administrador';
    }

    /**
     * Verifica si el usuario es agricultor
     */
    public function esAgricultor()
    {
        return $this->rol === 'agricultor';
    }

    /**
     * Verifica si el usuario es cliente
     */
    public function esCliente()
    {
        return $this->rol === 'cliente';
    }
}