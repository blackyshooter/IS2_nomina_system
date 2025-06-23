<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCargo extends Model
{
    protected $table = 'historial_cargos';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'empleado_id',
        'cargo_id',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Relaciones (opcional pero útil)
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'cargo_id', 'id');
    }
}
