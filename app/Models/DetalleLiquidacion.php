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
    public function liquidacionCabecera()
    {
        return $this->belongsTo(LiquidacionCabecera::class, 'liquidacion_id', 'id_liquidacion');
    }

    public function concepto()
    {
        return $this->belongsTo(ConceptoSalarial::class, 'concepto_id', 'id_concepto');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id', 'id_empleado');
    }
    
    public function conceptoSalarial()
    {
        return $this->belongsTo(ConceptoSalarial::class, 'concepto_id', 'id_concepto');
    }
    
    public function cabecera()
    {
        // liquidacion_id es FK en detalle_liquidacion
        // id_liquidacion es PK en liquidacion_cabeceras (asumido)
        return $this->belongsTo(LiquidacionCabecera::class, 'liquidacion_id', 'id_liquidacion');
    }
}
