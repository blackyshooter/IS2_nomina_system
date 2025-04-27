<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $fillable = ['nombre', 'tipo', 'afecta_ips', 'afecta_aguinaldo', 'frecuencia'];

    public function liquidaciones()
    {
        return $this->hasMany(Liquidacion::class);
    }
}
