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

    // Relación con hijos
    public function hijos()
    {
        return $this->hasMany(Hijo::class, 'empleado_id', 'id_empleado');
    }

    public function getRouteKeyName()
    {
        return 'id_empleado';
    }

    // Para que Laravel trate estas columnas como fechas Carbon
    protected $dates = ['fecha_ingreso', 'fecha_nacimiento'];

    // Accessor para fecha_ingreso
    public function getFechaIngresoAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Accessor para fecha_nacimiento
    public function getFechaNacimientoAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    /**
     * Calcula la bonificación por hijos menores de 18 años
     * si el salario_base es menor a 3 veces el salario mínimo oficial.
     *
     * @return float Monto de bonificación
     */
    public function bonificacionPorHijos()
    {
        // Obtener el salario mínimo oficial
        $salarioMinimo = (float) \App\Models\Parametro::obtenerValor('salario_minimo_oficial');

        // Si no está definido, retornar 0 para evitar error
        if (!$salarioMinimo) {
            return 0;
        }

        // Verificar condición salario_base < 3 * salario mínimo
        if ($this->salario_base >= 3 * $salarioMinimo) {
            return 0;
        }

        // Contar hijos menores de 18 años
        $hijosMenores = $this->hijos->filter(function($hijo) {
            return Carbon::parse($hijo->fecha_nacimiento)->diffInYears(Carbon::now()) < 18;
        })->count();

        if ($hijosMenores === 0) {
            return 0;
        }

        // Calcular bonificación: 5% del salario mínimo por hijo menor
        $bonificacion = $hijosMenores * 0.05 * $salarioMinimo;

        return round($bonificacion, 2);
    }

    /**
     * Calcula el IPS sobre conceptos imponibles para una liquidación dada.
     *
     * @param int $idLiquidacion ID de la liquidación cabecera
     * @return array ['total_imponible' => float, 'ips' => float]
     */
    public function calcularIps($idLiquidacion)
    {
        // Obtener el salario base (siempre imponible)
        $salarioBase = $this->salario_base;

        // Obtener conceptos imponibles de detalle_liquidacion para esta liquidacion y empleado
        $conceptosImponibles = \DB::table('detalle_liquidacion as dl')
            ->join('conceptos_salariales as cs', 'dl.concepto_id', '=', 'cs.id_concepto')
            ->where('dl.empleado_id', $this->id_empleado)
            ->where('dl.liquidacion_id', $idLiquidacion)
            ->where('cs.afecta_ips', true)
            ->select('dl.monto')
            ->get();

        // Sumar los montos imponibles (excluyendo salario_base si está repetido en conceptos)
        $totalConceptos = $conceptosImponibles->sum('monto');

        // Total imponible = salario_base + suma conceptos imponibles
        $totalImponible = $salarioBase + $totalConceptos;

        // Calcular IPS (9% de total imponible)
        $ips = round($totalImponible * 0.09, 2);

        return [
            'total_imponible' => $totalImponible,
            'ips' => $ips,
        ];
    }
}
