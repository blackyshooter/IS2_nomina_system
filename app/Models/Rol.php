<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_rol';

    protected $fillable = [
        'nombre_rol',
        'descripcion',
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_rol');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'roles_permisos', 'id_rol', 'id_permiso');
    }
}
