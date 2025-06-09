<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoEmpleado extends Model
{
     
    protected $table = 'conceptos_empleados';
    protected $fillable = [
        'empleado_id', 
        'concepto_id', 
        'monto', 
        'monto_mensual', 
        'monto_total', 
        'fecha_inicio', 
        'fecha_fin'
    ];

    public function concepto()
    {
        return $this->belongsTo(ConceptoSalarial::class, 'concepto_id');
    }
    public function conceptoSalarial()
    {
        return $this->belongsTo(ConceptoSalarial::class, 'concepto_id', 'id_concepto');
    }

   public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }
}