<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoSalarial extends Model
{
    use HasFactory;
    protected $table = 'conceptos_salariales';


    protected $primaryKey = 'id_concepto';

    protected $fillable = [
        'tipo_concepto',
        'descripcion',
        'fijo',
        'afecta_ips',
        'afecta_aguinaldo',
    ];

    protected $casts = [
        'fijo' => 'boolean',
        'afecta_ips' => 'boolean',
        'afecta_aguinaldo' => 'boolean',
    ];

    public function conceptosEmpleados()
    {
        return $this->hasMany(ConceptoEmpleado::class, 'concepto_id', 'id_concepto');
    }

    public function detalleLiquidaciones()
    {
        return $this->hasMany(DetalleLiquidacion::class, 'concepto_id', 'id_concepto');
    }
}