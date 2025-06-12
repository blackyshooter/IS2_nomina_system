<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Ausencia;
use App\Models\Prestamo;
use App\Models\ConceptoSalarial;
use App\Models\LiquidacionCabecera;
use App\Models\DetalleLiquidacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class ReporteController extends Controller
{
    /**
     * Muestra el formulario para seleccionar el período de nómina
     * y genera el reporte.
     */
    public function index(Request $request)
    {
        // Puedes pasar empleados aquí si quieres un filtro por empleado
        $empleados = Empleado::orderBy('nombre')->get();
        $reporteLiquidaciones = new Collection(); // <--- ¡Asegúrate de que esto esté aquí!
        $periodo = $request->input('periodo'); // Ejemplo: '2024-05'

        if ($periodo) {
            // Intenta cargar la liquidación ya generada para el período
            $liquidacionCabecera = LiquidacionCabecera::where('periodo', $periodo)->first();

            if ($liquidacionCabecera) {
                // Si la liquidación ya existe, cárgala
                $reporteLiquidaciones = DetalleLiquidacion::with(['empleado', 'conceptoSalarial'])
                    ->where('liquidacion_id', $liquidacionCabecera->id_liquidacion)
                    ->get()
                    ->groupBy('empleado_id'); // Agrupamos por empleado para la vista
            } else {
                // Si no existe, la generamos
                $reporteLiquidaciones = $this->generarNominaParaPeriodo($periodo);
            }
        }

        return view('nominas.index', compact('empleados', 'reporteLiquidaciones', 'periodo'));
    }

    /**
     * Genera la nómina para un período específico y guarda en la base de datos.
     * @param string $periodo_str Formato 'YYYY-MM'
     * @return \Illuminate\Support\Collection Colección de detalles de liquidación agrupados por empleado
     */
    private function generarNominaParaPeriodo(string $periodo_str)
    {
        // Parsear el período de inicio y fin (ej. '2024-05' -> 2024-05-01 a 2024-05-31)
        $fechaInicioPeriodo = Carbon::parse($periodo_str . '-01')->startOfMonth();
        $fechaFinPeriodo = Carbon::parse($periodo_str . '-01')->endOfMonth();

        $empleados = Empleado::all();
        $conceptosDescuentoAusencia = ConceptoSalarial::where('descripcion', 'Descuento por Ausencia Injustificada')->first();
        $conceptosDescuentoPrestamo = ConceptoSalarial::where('descripcion', 'Descuento por Cuota de Préstamo')->first();
        $conceptosSalarioBase = ConceptoSalarial::where('descripcion', 'Salario Base')->first();


        if (!$conceptosDescuentoAusencia || !$conceptosDescuentoPrestamo || !$conceptosSalarioBase) {
            // Manejar error si los conceptos no existen
            throw new \Exception("Conceptos salariales de descuento o salario base no configurados. Por favor, revísalos.");
        }

        $liquidacionCabecera = LiquidacionCabecera::create([
            'fecha_liquidacion' => Carbon::now(),
            'periodo' => $periodo_str,
            'monto_total' => 0, // Se actualizará al final
        ]);

        $reporteDetallesPorEmpleado = collect(); // Para la vista

        foreach ($empleados as $empleado) {
            $totalHaberes = 0;
            $totalDebitos = 0;
            $detallesParaEmpleado = collect();

            // 1. Calcular Salario Base (Crédito)
            // Asumo que el salario base se encuentra en la tabla `conceptos_empleados`
            // o directamente en el modelo de empleado
            $salarioBaseConceptoEmpleado = $empleado->conceptosEmpleados()->where('concepto_id', $conceptosSalarioBase->id_concepto)->first();

            $salarioMensual = $salarioBaseConceptoEmpleado ? $salarioBaseConceptoEmpleado->monto : 0;
            $salarioDiario = $salarioMensual > 0 ? ($salarioMensual / 30) : 0; // Asumiendo 30 días para el cálculo diario

            if ($salarioMensual > 0) {
                 $detallesParaEmpleado->push(DetalleLiquidacion::create([
                    'liquidacion_id' => $liquidacionCabecera->id_liquidacion,
                    'empleado_id' => $empleado->id_empleado,
                    'concepto_id' => $conceptosSalarioBase->id_concepto,
                    'monto' => $salarioMensual,
                ]));
                $totalHaberes += $salarioMensual;
            }


            // 2. Aplicar Descuentos por Ausencias Injustificadas
            $ausenciasInjustificadas = $empleado->ausencias()
                ->where('tipo_ausencia', 'injustificada')
                ->where(function ($query) use ($fechaInicioPeriodo, $fechaFinPeriodo) {
                    $query->whereBetween('fecha_inicio', [$fechaInicioPeriodo, $fechaFinPeriodo])
                          ->orWhereBetween('fecha_fin', [$fechaInicioPeriodo, $fechaFinPeriodo])
                          ->orWhere(function ($q) use ($fechaInicioPeriodo, $fechaFinPeriodo) {
                              $q->where('fecha_inicio', '<', $fechaInicioPeriodo)
                                ->where('fecha_fin', '>', $fechaFinPeriodo);
                          });
                })
                ->get();

            $descuentoTotalAusencias = 0;
            foreach ($ausenciasInjustificadas as $ausencia) {
                // Calcular días de ausencia que caen dentro del período de nómina
                $inicioEfectivo = Carbon::parse($ausencia->fecha_inicio)->max($fechaInicioPeriodo);
                $finEfectivo = Carbon::parse($ausencia->fecha_fin)->min($fechaFinPeriodo);

                // Asegurarse de que el rango es válido
                if ($inicioEfectivo->lte($finEfectivo)) {
                    $diasAusenteEnPeriodo = $inicioEfectivo->diffInDays($finEfectivo) + 1;
                    $descuentoPorAusencia = $diasAusenteEnPeriodo * $salarioDiario;
                    $descuentoTotalAusencias += $descuentoPorAusencia;
                }
            }

            if ($descuentoTotalAusencias > 0) {
                $detallesParaEmpleado->push(DetalleLiquidacion::create([
                    'liquidacion_id' => $liquidacionCabecera->id_liquidacion,
                    'empleado_id' => $empleado->id_empleado,
                    'concepto_id' => $conceptosDescuentoAusencia->id_concepto,
                    'monto' => $descuentoTotalAusencias * -1, // Negativo para débito
                ]));
                $totalDebitos += $descuentoTotalAusencias;
            }

            // 3. Aplicar Descuentos por Préstamos
            $prestamosActivos = $empleado->prestamos()
                ->where('activo', true)
                ->where('cuotas_restantes', '>', 0)
                ->where('fecha_inicio_pago', '<=', $fechaFinPeriodo) // Solo si el pago ya debía haber iniciado
                ->get();

            $descuentoTotalPrestamos = 0;
            foreach ($prestamosActivos as $prestamo) {
                // Verificar si la cuota aplica para este período.
                // Podrías tener una lógica más compleja aquí, como fechas de pago específicas,
                // pero por simplicidad, aplicamos la cuota si el préstamo está activo y tiene cuotas restantes.
                $montoCuotaAplicar = min($prestamo->monto_cuota, $prestamo->monto_total - ($prestamo->monto_cuota * ($prestamo->original_cuotas - $prestamo->cuotas_restantes))); // Ajuste para no descontar más de lo debido

                if ($montoCuotaAplicar > 0) {
                    $detallesParaEmpleado->push(DetalleLiquidacion::create([
                        'liquidacion_id' => $liquidacionCabecera->id_liquidacion,
                        'empleado_id' => $empleado->id_empleado,
                        'concepto_id' => $conceptosDescuentoPrestamo->id_concepto,
                        'monto' => $montoCuotaAplicar * -1, // Negativo para débito
                    ]));
                    $totalDebitos += $montoCuotaAplicar;

                    // Actualizar el préstamo: reducir cuotas y marcar como inactivo si se salda
                    $prestamo->decrement('cuotas_restantes');
                    $prestamo->monto_total -= $montoCuotaAplicar; // Reduce el monto total restante
                    if ($prestamo->monto_total <= 0 || $prestamo->cuotas_restantes <= 0) {
                        $prestamo->activo = false;
                    }
                    $prestamo->save();
                }
            }
            
            // 4. Calcular Total Neto
            $salarioNeto = $totalHaberes - $totalDebitos;

            // Almacenar los detalles y el neto para la vista
            $detallesParaEmpleado['total_haberes'] = $totalHaberes;
            $detallesParaEmpleado['total_debitos'] = $totalDebitos;
            $detallesParaEmpleado['salario_neto'] = $salarioNeto;
            $reporteDetallesPorEmpleado->put($empleado->id_empleado, $detallesParaEmpleado);
        }

        // Actualizar el monto_total de la cabecera de la liquidación
        $liquidacionCabecera->monto_total = $reporteDetallesPorEmpleado->sum('salario_neto');
        $liquidacionCabecera->save();

        return $reporteDetallesPorEmpleado;
    }
}