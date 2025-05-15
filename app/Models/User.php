<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true; // Cambia a false si no usas timestamps

    protected $fillable = [
        'email',
        'password',
        'nombre_usuario',
        'id_empleado',
    ];

    protected $hidden = [
        'password',
        'remember_token', // si usas remember_token
    ];

    // Relación con empleado (si quieres)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }
}
