<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Empleado extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_empleado';

    protected $fillable = [
        'nombre',
        'apellido',
        'fecha_ingreso',
        'cedula',
        'correo',
        'telefono',
        'fecha_nacimiento',
        'salario_base',
    ];

    protected $casts = [
        'fecha_ingreso' => 'datetime',
        'fecha_nacimiento' => 'datetime',
    ];
    public function ausencias()
    {
        return $this->hasMany(Ausencia::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
    // Relación con hijos
    public function hijos()
    {
        return $this->hasMany(Hijo::class, 'empleado_id', 'id_empleado');
    }

    // Relación con detalles de liquidación (detalle_liquidacion)
    public function liquidacionDetalles()
    {
        return $this->hasMany(DetalleLiquidacion::class, 'empleado_id', 'id_empleado');
    }

    // Relación indirecta con liquidacion_cabeceras a través de detalles
    public function liquidacionCabeceras()
    {
        // Por la tabla detalle_liquidacion que tiene liquidacion_id que apunta a liquidacion_cabeceras.id_liquidacion_cabecera
        return $this->hasManyThrough(
            LiquidacionCabecera::class,    // Modelo destino
            LiquidacionDetalle::class,     // Modelo intermedio
            'empleado_id',                 // FK en LiquidacionDetalle que apunta a Empleado
            'id_liquidacion_cabecera',     // PK en LiquidacionCabecera
            'id_empleado',                 // PK en Empleado
            'liquidacion_id'               // FK en LiquidacionDetalle que apunta a LiquidacionCabecera
        );
    }

    public function getRouteKeyName()
    {
        return 'id_empleado';
    }

    // Bonificación por hijos menores de 18 años (igual que antes)
    public function bonificacionPorHijos()
    {
        $salarioMinimo = (float) \App\Models\Parametro::obtenerValor('salario_minimo_oficial');

        if (!$salarioMinimo) {
            return 0;
        }

        if ($this->salario_base >= 3 * $salarioMinimo) {
            return 0;
        }

        $hijosMenores = $this->hijos->filter(function($hijo) {
            return Carbon::parse($hijo->fecha_nacimiento)->age < 18;
        })->count();

        if ($hijosMenores === 0) {
            return 0;
        }

        return round($hijosMenores * 0.05 * $salarioMinimo, 2);
    }

    // Cálculo IPS sobre conceptos imponibles para liquidación dada
    public function calcularIps($idLiquidacion)
    {
        $salarioBase = $this->salario_base;

        $conceptosImponibles = \DB::table('detalle_liquidacion as dl')
            ->join('conceptos_salariales as cs', 'dl.concepto_id', '=', 'cs.id_concepto')
            ->where('dl.empleado_id', $this->id_empleado)
            ->where('dl.liquidacion_id', $idLiquidacion)
            ->where('cs.afecta_ips', true)
            ->select('dl.monto')
            ->get();

        $totalConceptos = $conceptosImponibles->sum('monto');

        $totalImponible = $salarioBase + $totalConceptos;

        $ips = round($totalImponible * 0.09, 2);

        return [
            'total_imponible' => $totalImponible,
            'ips' => $ips,
        ];
    }
}
