<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; // Si no usas created_at/updated_at

    protected $fillable = [
        'nombre',
        'apellido',
        'correo',
        'contraseña',
        'direccion',
        'telefono',
        'rol',
    ];

    protected $hidden = [
        'contraseña',
    ];

    // Para que Auth use 'contraseña' en lugar de 'password'
    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
