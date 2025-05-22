<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleLiquidacion extends Model
{
    protected $table = 'detalle_liquidacion';
    protected $primaryKey = 'id_detalle_liquidacion';
    public $timestamps = true;

    protected $fillable = [
        'liquidacion_id',
        'empleado_id',
        'concepto_id',
        'monto'
    ];

    // Relación hacia la cabecera de la liquidación
    public function cabecera()
    {
        // liquidacion_id es FK en detalle_liquidacion
        // id_liquidacion es PK en liquidacion_cabeceras (asumido)
        return $this->belongsTo(LiquidacionCabecera::class, 'liquidacion_id', 'id_liquidacion');
    }
}
