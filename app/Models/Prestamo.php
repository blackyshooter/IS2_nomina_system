<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
    'empleado_id',
    'monto_total',
    'cuota_mensual',
    'monto_restante',
    'activo',
];

    protected $casts = [
        'fecha_inicio_pago' => 'date',
        'activo' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }
}