<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Liquidacion extends Model
{
    protected $fillable = ['empleado_id', 'concepto_id', 'monto'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function concepto()
    {
        return $this->belongsTo(Concepto::class);
    }
}
