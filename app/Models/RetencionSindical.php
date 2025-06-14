<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RetencionSindical extends Model
{
    protected $table = 'retenciones_sindicales';

    protected $primaryKey = 'id';

    protected $fillable = [
        'empleado_id',
        'monto_mensual',
        'activo',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }

    public function scopeActivo($query)
    {
        return $query->where('activo', true);
    }
}
