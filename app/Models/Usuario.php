<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name', 'email', 'password', 'id_usuario', 'id_empleado', 'id_rol',
    ];
    
    // Ocultar contraseña en respuestas JSON
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
    // Usado por Laravel para saber qué campo es el "usuario" para login
    public function getAuthIdentifierName()
    {
        return 'email';
    }
    
    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->contraseña;
    }

    

}
