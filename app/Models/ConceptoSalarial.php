<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoSalarial extends Model
{
    use HasFactory;

    protected $table = 'conceptos_salariales'; // 👈 Tabla real

    protected $primaryKey = 'id_concepto';

    protected $fillable = [
        'tipo_concepto',
        'descripcion',
        'fijo',
        'afecta_ips',
        'afecta_aguinaldo',
    ];
}
