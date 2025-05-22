<?php

namespace App\Services;

use App\Models\Empleado;
use App\Models\ConceptoSalarial;
use App\Models\LiquidacionCabecera;
use App\Models\DetalleLiquidacion;
use App\Models\Parametro;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LiquidacionService
{
    protected static $salarioMinimo = null;

    public function obtenerSalarioMinimo()
    {
        if (is_null(self::$salarioMinimo)) {
            self::$salarioMinimo = Parametro::where('clave', 'salario_minimo_oficial')->value('valor');
        }
        return self::$salarioMinimo;
    }

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
            $salarioMinimo = $this->obtenerSalarioMinimo();
            $salarioEmpleado = $empleado->salario_base;

            if ($salarioEmpleado < ($salarioMinimo * 3)) {
                $hijosMenores = $empleado->hijos()
                    ->whereDate('fecha_nacimiento', '>', now()->subYears(18))
                    ->count();

                $montoBonif = round($salarioMinimo * 0.05 * $hijosMenores, 2);

                if ($montoBonif > 0) {
                    $conceptos[] = [
                        'concepto_id' => $conceptoBonif->id_concepto,
                        'descripcion' => $conceptoBonif->descripcion,
                        'tipo' => $conceptoBonif->tipo_concepto,
                        'monto' => $montoBonif,
                    ];
                }
            }
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
            if ($concepto['tipo'] === 'credito') {
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

    /**
     * Guardar liquidación evitando duplicados.
     *
     * @throws \Exception si ya existe liquidación para empleado y periodo
     */
    public function guardarLiquidacion(Empleado $empleado, array $montos, string $periodo): void
    {
        // Validar duplicado
        $existe = LiquidacionCabecera::where('periodo', $periodo)
            ->whereHas('detalles', function ($query) use ($empleado) {
                $query->where('empleado_id', $empleado->id_empleado);
            })
            ->exists();

        if ($existe) {
            throw new \Exception("Ya existe una liquidación para el empleado {$empleado->nombre} en el periodo {$periodo}");
        }

        DB::transaction(function () use ($empleado, $montos, $periodo) {
            $total = array_sum($montos);

            // Insertar en cabecera
            $liquidacionCabecera = LiquidacionCabecera::create([
                'fecha_liquidacion' => now(),
                'periodo' => $periodo,
                'monto_total' => $total,
            ]);

            // Insertar detalles
            foreach ($montos as $concepto_id => $monto) {
                DetalleLiquidacion::create([
                    'liquidacion_id' => $liquidacionCabecera->id_liquidacion,
                    'empleado_id' => $empleado->id_empleado,
                    'concepto_id' => $concepto_id,
                    'monto' => $monto,
                ]);
            }
        });
    }

    // Método para liquidar todos - puedes implementarlo según tu lógica
    public function liquidarTodos(string $periodo): array
{
    $empleados = Empleado::all(); // O filtrado según la lógica de total.blade.php si tienes alguna condición

    $resultados = [
        'liquidaciones_realizadas' => [],
        'empleados_omitidos' => [],
    ];

    foreach ($empleados as $empleado) {
        try {
            // Primero, validar si ya existe para evitar excepción
            $existe = LiquidacionCabecera::where('periodo', $periodo)
                ->whereHas('detalles', function ($query) use ($empleado) {
                    $query->where('empleado_id', $empleado->id_empleado);
                })
                ->exists();

            if ($existe) {
                $resultados['empleados_omitidos'][] = [
                    'empleado_id' => $empleado->id_empleado,
                    'nombre' => $empleado->nombre,
                    'motivo' => 'Ya tiene liquidación para este periodo',
                ];
                continue;
            }

            // Obtener conceptos calculados para el empleado
            $liquidacion = $this->calcularLiquidacion($empleado);

            // Guardar la liquidación
            $this->guardarLiquidacion($empleado, array_column($liquidacion['conceptos'], 'monto', 'concepto_id'), $periodo);

            $resultados['liquidaciones_realizadas'][] = [
                'empleado_id' => $empleado->id_empleado,
                'nombre' => $empleado->nombre,
                'total_neto' => $liquidacion['total_neto'],
            ];
        } catch (\Exception $e) {
            $resultados['empleados_omitidos'][] = [
                'empleado_id' => $empleado->id_empleado,
                'nombre' => $empleado->nombre,
                'motivo' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    return $resultados;
}

}
