<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'name', 'email', 'password', 'id_usuario', 'rol', 'id_empleado'
    ];
    
    // Ocultar contraseña en respuestas JSON
    protected $hidden = [
        'password', 'remember_token',
    ];
    

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    public function empleado(){
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

}
