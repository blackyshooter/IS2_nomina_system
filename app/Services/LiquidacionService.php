<?php

namespace App\Services;

use App\Models\Empleado;
use App\Models\ConceptoSalarial;
use App\Models\Parametro;
use App\Models\Liquidacion;

class LiquidacionService
{
    /**
     * Obtiene los conceptos fijos para la liquidación de un empleado,
     * con sus respectivos montos calculados.
     *
     * @param Empleado $empleado
     * @return array
     */
    public function obtenerConceptosFijos(Empleado $empleado): array
    {
        $conceptos = [];

        // Salario Base
        $conceptoSalario = ConceptoSalarial::where('descripcion', 'Salario Base')->first();
        if ($conceptoSalario) {
            $conceptos[] = [
                'concepto_id' => $conceptoSalario->id_concepto,
                'descripcion' => $conceptoSalario->descripcion,
                'tipo' => $conceptoSalario->tipo_concepto,
                'monto' => $empleado->salario_base,
            ];
        }

        // Bonificación por hijos (usamos función del modelo Empleado)
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

        // Descuento IPS (ejemplo 9% sobre salario base)
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

    /**
     * Calcula la liquidación total y detalles para un empleado.
     *
     * @param Empleado $empleado
     * @return array
     */
    public function calcularLiquidacion(Empleado $empleado): array
    {
        $conceptos = $this->obtenerConceptosFijos($empleado);

        $totalCredito = 0;
        $totalDebito = 0;

        foreach ($conceptos as $concepto) {
            if ($concepto['tipo'] === 'C') { // Crédito
                $totalCredito += $concepto['monto'];
            } else { // Débito
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

    /**
     * Guarda la liquidación para un empleado en la base de datos.
     *
     * @param Empleado $empleado
     * @param array $montos Array con los montos manuales o calculados para cada concepto
     *                      clave: concepto_id, valor: monto
     * @return void
     */
    public function guardarLiquidacion(Empleado $empleado, array $montos): void
    {
        // Aquí asumimos que tenés una tabla 'liquidaciones' con:
        // id, empleado_id, concepto_id, monto, created_at, updated_at

        // Eliminar liquidaciones anteriores del empleado para el periodo (si aplica)
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
