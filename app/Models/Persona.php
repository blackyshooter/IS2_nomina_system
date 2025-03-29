<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'cedula';
    public $incrementing = false; // porque la cédula no se autoincrementa
    protected $keyType = 'int';

    protected $fillable = [
        'cedula',
        'nombre',
        'apellido',
        'fecha_nacimiento'
    ];

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'cedula', 'cedula');
    }
}
