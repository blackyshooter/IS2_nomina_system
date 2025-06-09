<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionCabecera extends Model
{
    protected $table = 'liquidacion_cabecera'; // Ajusta el nombre de la tabla si es distinto

    protected $primaryKey = 'id_liquidacion';

    protected $fillable = [
        'fecha_liquidacion',
        'periodo',
        'monto_total',
        // otros campos que tengas
    ];
    protected $casts = [
        'fecha_liquidacion' => 'date',
    ];
    public function detalleLiquidaciones()
    {
        return $this->hasMany(DetalleLiquidacion::class, 'liquidacion_id', 'id_liquidacion');
    }
    // Relación con detalles de la liquidación
    public function detalles()
    {
        return $this->hasMany(DetalleLiquidacion::class, 'liquidacion_id', 'id_liquidacion');
    }
}
