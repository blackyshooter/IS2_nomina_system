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

        // SALARIO BASE
        $conceptoSalario = ConceptoSalarial::where('descripcion', 'Salario Base')->first();
        if ($conceptoSalario) {
            $conceptos[] = [
                'concepto_id' => $conceptoSalario->id_concepto,
                'descripcion' => $conceptoSalario->descripcion,
                'tipo' => $conceptoSalario->tipo_concepto,
                'monto' => $empleado->salario_base,
            ];
        }

        // BONIFICACIÓN POR HIJOS
        $conceptoBonif = ConceptoSalarial::where('descripcion', 'Bonificacion por hijo')->first();
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

        // DESCUENTO IPS
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

        // DESCUENTO POR AUSENCIAS INJUSTIFICADAS
        $conceptoAusencia = ConceptoSalarial::where('descripcion', 'Descuento por Ausencia')->first();
        if ($conceptoAusencia) {
            $inicioMes = now()->startOfMonth();
            $finMes = now()->endOfMonth();

            $ausencias = $empleado->ausencias()
                ->where('tipo_ausencia', 'injustificada')
                ->where(function ($query) use ($inicioMes, $finMes) {
                    $query->whereBetween('fecha_inicio', [$inicioMes, $finMes])
                        ->orWhereBetween('fecha_fin', [$inicioMes, $finMes])
                        ->orWhere(function ($q) use ($inicioMes, $finMes) {
                            $q->where('fecha_inicio', '<', $inicioMes)
                            ->where('fecha_fin', '>', $finMes);
                        });
                })
                ->get();

            $totalDias = 0;
            foreach ($ausencias as $ausencia) {
                $inicio = \Carbon\Carbon::parse($ausencia->fecha_inicio)->max($inicioMes);
                $fin = \Carbon\Carbon::parse($ausencia->fecha_fin)->min($finMes);

                if ($inicio <= $fin) {
                    $totalDias += $inicio->diffInDays($fin) + 1;
                }
            }

            if ($totalDias > 0 && $empleado->salario_base > 0) {
                $salarioDiario = $empleado->salario_base / 30;
                $montoDescuento = round($totalDias * $salarioDiario, 2);

                $conceptos[] = [
                    'concepto_id' => $conceptoAusencia->id_concepto,
                    'descripcion' => $conceptoAusencia->descripcion,
                    'tipo' => 'debito',
                    'monto' => $montoDescuento,
                ];
            }
        }

        // RETENCIÓN SINDICAL
        $retencionSindical = $empleado->retencionSindical;
        $conceptoSindical = ConceptoSalarial::where('descripcion', 'Retenciones Sindicales')->first();
        if ($retencionSindical && $conceptoSindical) {
            $conceptos[] = [
                'concepto_id' => $conceptoSindical->id_concepto,
                'descripcion' => $conceptoSindical->descripcion,
                'tipo' => 'debito',
                'monto' => $retencionSindical->monto_mensual,
            ];
        }

        // EMBARGO JUDICIAL
        $embargo = $empleado->embargoJudicial;
        $conceptoEmbargo = ConceptoSalarial::where('descripcion', 'Embargos Judiciales')->first();
        if ($embargo && $embargo->activo && $embargo->monto_restante > 0 && $conceptoEmbargo) {
            $montoDescontar = min($embargo->cuota_mensual, $embargo->monto_restante);

            $conceptos[] = [
                'concepto_id' => $conceptoEmbargo->id_concepto,
                'descripcion' => $conceptoEmbargo->descripcion,
                'tipo' => $conceptoEmbargo->tipo_concepto,
                'monto' => $montoDescontar,
            ];

            $embargo->monto_restante -= $montoDescontar;
            if ($embargo->monto_restante <= 0) {
                $embargo->activo = false;
            }
            $embargo->save();
        }

        // PRÉSTAMOS
        // DESCUENTOS POR PRÉSTAMOS
        $prestamos = $empleado->prestamos()
            ->where('activo', true)
            ->where('monto_restante', '>', 0)
            ->get();

        foreach ($prestamos as $prestamo) {
            $conceptoPrestamo = ConceptoSalarial::where('descripcion', 'Descuentos por Prestamos')->first();

            if ($conceptoPrestamo) {
                $montoCuota = min($prestamo->monto_cuota, $prestamo->monto_restante);


                $conceptos[] = [
                    'concepto_id' => $conceptoPrestamo->id_concepto,
                    'descripcion' => $conceptoPrestamo->descripcion,
                    'tipo' => $conceptoPrestamo->tipo_concepto,
                    'monto' => $montoCuota,
                ];

                // Actualizar saldo del préstamo
                $prestamo->monto_restante -= $montoCuota;
                if ($prestamo->monto_restante <= 0) {
                    $prestamo->activo = false;
                }
                $prestamo->save();
                }
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
   $empleados = Empleado::with(['retencionSindical', 'embargoJudicial', 'prestamos'])->get();
 

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
