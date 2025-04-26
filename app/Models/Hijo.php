<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hijo extends Model
{
    protected $fillable = ['empleado_id', 'fecha_nacimiento'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
