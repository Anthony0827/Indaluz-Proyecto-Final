<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Verificacion extends Model
{
    protected $table        = 'verificaciones';
    protected $primaryKey   = 'id_verificacion';
    public    $timestamps   = false;

    protected $fillable = [
        'id_usuario',
        'token',
        'verificado',
    ];
}
