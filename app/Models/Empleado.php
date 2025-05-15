<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_ingreso',
        'cedula',
        'correo',
        'telefono',
        'fecha_nacimiento',
    ];

    // Relación con hijos
    public function hijos()
    {
        return $this->hasMany(Hijo::class, 'empleado_id', 'id_empleado');
    }

    public function getRouteKeyName()
    {
        return 'id_empleado';
    }

    // Para que Laravel trate estas columnas como fechas Carbon
    protected $dates = ['fecha_ingreso', 'fecha_nacimiento'];

    // Accessor para fecha_ingreso
    public function getFechaIngresoAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Accessor para fecha_nacimiento
    public function getFechaNacimientoAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }
}
