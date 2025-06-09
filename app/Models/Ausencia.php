<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ausencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'fecha_inicio',
        'fecha_fin',
        'dias_ausente',
        'tipo_ausencia',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}