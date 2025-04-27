<?php

namespace App\Services;

use App\Models\Empleado;
use App\Models\Parametro;
use App\Models\Concepto;
use App\Models\Liquidacion;

class LiquidacionService
{
    public function calcular(Empleado $empleado): array
    {
        $conceptos = [];

        $salarioMinimo = Parametro::obtener('salario_minimo');
        $sueldoBase = $empleado->sueldo_base;

        // Concepto: Sueldo Base (siempre imponible)
        $conceptos[] = [
            'descripcion' => 'Sueldo Base',
            'monto' => $sueldoBase,
            'afecta_ips' => true,
            'tipo' => 'credito',
        ];

        // Concepto: Bonificación por hijo menor a 18 años
        $hijos = $empleado->hijos()->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) < 18')->count();

        if ($sueldoBase < ($salarioMinimo * 3) && $hijos > 0) {
            $bonificacion = 0.05 * $salarioMinimo * $hijos;

            $conceptos[] = [
                'descripcion' => 'Bonificación por Hijo',
                'monto' => $bonificacion,
                'afecta_ips' => false,
                'tipo' => 'credito',
            ];
        }

        // Cálculo de IPS (9% sobre imponibles)
        $baseImponible = collect($conceptos)
            ->where('tipo', 'credito')
            ->where('afecta_ips', true)
            ->sum('monto');

        $ips = $baseImponible * 0.09;

        $conceptos[] = [
            'descripcion' => 'Descuento IPS',
            'monto' => -$ips,
            'afecta_ips' => false,
            'tipo' => 'debito',
        ];

        return $conceptos;
    }
}
