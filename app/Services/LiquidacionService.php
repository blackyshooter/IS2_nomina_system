<?php

namespace App\Services;

use App\Models\Empleado;
use App\Models\ConceptoSalarial;
use App\Models\Liquidacion;

class LiquidacionService
{
    public function obtenerConceptosFijos(Empleado $empleado): array
    {
        $conceptos = [];

        $conceptoSalario = ConceptoSalarial::where('descripcion', 'Salario Base')->first();
        if ($conceptoSalario) {
            $conceptos[] = [
                'concepto_id' => $conceptoSalario->id_concepto,
                'descripcion' => $conceptoSalario->descripcion,
                'tipo' => $conceptoSalario->tipo_concepto,
                'monto' => $empleado->salario_base,
            ];
        }

        $conceptoBonif = ConceptoSalarial::where('descripcion', 'Bonificación por hijos')->first();
        if ($conceptoBonif) {
            $montoBonif = $empleado->bonificacionPorHijos();
            $conceptos[] = [
                'concepto_id' => $conceptoBonif->id_concepto,
                'descripcion' => $conceptoBonif->descripcion,
                'tipo' => $conceptoBonif->tipo_concepto,
                'monto' => $montoBonif,
            ];
        }

        $conceptoIps = ConceptoSalarial::where('descripcion', 'Descuento IPS')->first();
        if ($conceptoIps) {
            $montoIps = round($empleado->salario_base * 0.09, 2);
            $conceptos[] = [
                'concepto_id' => $conceptoIps->id_concepto,
                'descripcion' => $conceptoIps->descripcion,
                'tipo' => $conceptoIps->tipo_concepto,
                'monto' => $montoIps,
            ];
        }

        return $conceptos;
    }

    public function calcularLiquidacion(Empleado $empleado): array
    {
        $conceptos = $this->obtenerConceptosFijos($empleado);

        $totalCredito = 0;
        $totalDebito = 0;

        foreach ($conceptos as $concepto) {
            if ($concepto['tipo'] === 'C') {
                $totalCredito += $concepto['monto'];
            } else {
                $totalDebito += $concepto['monto'];
            }
        }

        return [
            'conceptos' => $conceptos,
            'total_credito' => $totalCredito,
            'total_debito' => $totalDebito,
            'total_neto' => $totalCredito - $totalDebito,
        ];
    }

    public function guardarLiquidacion(Empleado $empleado, array $montos): void
    {
        // Eliminamos liquidaciones anteriores solo del empleado (en detalle)
        Liquidacion::where('empleado_id', $empleado->id_empleado)->delete();

        foreach ($montos as $concepto_id => $monto) {
            Liquidacion::create([
                'empleado_id' => $empleado->id_empleado,
                'concepto_id' => $concepto_id,
                'monto' => $monto,
            ]);
        }
    }
}
