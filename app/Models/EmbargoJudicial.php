<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmbargoJudicial extends Model
{
    protected $table = 'embargos_judiciales';

    protected $primaryKey = 'id';

    protected $fillable = [
        'empleado_id',
        'monto_total',
        'cuota_mensual',
        'monto_restante',
        'activo', // booleano: true/false
    ];

    public function empleado()
    {
          return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }
    public function scopeActive($query)
    {
        return $query->where('activo', true);
    }

}
