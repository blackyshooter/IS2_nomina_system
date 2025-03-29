<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'email',
        'contraseña',
        'nombre_usuario',
        'id_empleado'
    ];

    public $timestamps = false;

    protected $hidden = ['contraseña'];

    public function getAuthPassword()
    {
        return $this->contraseña;
    }
}
