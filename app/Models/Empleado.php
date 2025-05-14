<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

   protected $fillable = [
    'id_empleado',
    'nombre',
    'apellido',
    'fecha_ingreso',
    'cedula',
    'correo',
    'telefono',
    'fecha_nacimiento',
];


    public function persona()
    {
        return $this->belongsTo(Persona::class, 'cedula', 'cedula');
    }

    public function hijos()
    {
        return $this->hasMany(Hijo::class, 'id_empleado');
    }
}