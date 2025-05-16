<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    protected $table = 'liquidaciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'empleado_id',
        'concepto_id',
        'monto',
    ];

    public $timestamps = true;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }

    public function concepto()
    {
        return $this->belongsTo(ConceptoSalarial::class, 'concepto_id', 'id_concepto');
    }
}
