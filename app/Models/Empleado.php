<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'cedula',
        'telefono',
        'sueldo_base',
        'fecha_ingreso',
        'cargo'
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class, 'cedula', 'cedula');
    }
}
