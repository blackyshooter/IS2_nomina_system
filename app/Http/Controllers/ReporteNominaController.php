<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiquidacionCabecera;
use App\Models\DetalleLiquidacion;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReporteNominaExport;

class ReporteNominaController extends Controller
{
    public function index(Request $request)
    {
        $periodo = $request->input('periodo');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $salarioMin = $request->input('salario_min');
        $salarioMax = $request->input('salario_max');

        $reporteLiquidaciones = new Collection();
        $montoTotal = 0;

        $queryCabeceras = LiquidacionCabecera::with('detalles.conceptoSalarial', 'detalles.empleado');

        if ($periodo) {
            $fechaInicioPeriodo = Carbon::parse($periodo . '-01')->startOfMonth();
            $fechaFinPeriodo = Carbon::parse($periodo . '-01')->endOfMonth();
            $queryCabeceras->whereBetween('fecha_liquidacion', [$fechaInicioPeriodo, $fechaFinPeriodo]);
        } elseif ($fechaInicio && $fechaFin) {
            $queryCabeceras->whereBetween('fecha_liquidacion', [Carbon::parse($fechaInicio), Carbon::parse($fechaFin)]);
        }

        $cabeceras = $queryCabeceras->get();

        foreach ($cabeceras as $cabecera) {
            foreach ($cabecera->detalles as $detalle) {
                $empleado = $detalle->empleado;

                if (!$empleado) continue;

                $id = $empleado->cedula ?? $empleado->id_empleado;
                if (!isset($reporteLiquidaciones[$id])) {
                    $reporteLiquidaciones[$id] = collect([
                        'empleado' => $empleado,
                        'total_haberes' => 0,
                        'total_debitos' => 0,
                        'salario_neto' => 0,
                    ]);
                }

                $tipo = $detalle->conceptoSalarial?->tipo_concepto;
                $monto = $detalle->monto;

                if ($tipo === 'credito') {
                    $reporteLiquidaciones[$id]['total_haberes'] += $monto;
                } elseif ($tipo === 'debito') {
                    $reporteLiquidaciones[$id]['total_debitos'] += abs($monto);
                }
            }
        }

        foreach ($reporteLiquidaciones as $id => $data) {
            $neto = $data['total_haberes'] - $data['total_debitos'];
            $data['salario_neto'] = $neto;

            // Aplicar filtro por salario neto
            if (($salarioMin && $neto < $salarioMin) || ($salarioMax && $neto > $salarioMax)) {
                unset($reporteLiquidaciones[$id]);
                continue;
            }

            $montoTotal += $neto;
        }

        return view('reportes.nomina_general', [
            'reporteLiquidaciones' => $reporteLiquidaciones,
            'periodo' => $periodo,
            'montoTotal' => $montoTotal,
        ]);
    }

    public function exportarPdf(Request $request)
    {
        $data = $this->index($request)->getData();
        $pdf = Pdf::loadView('reportes.nomina_general_pdf', $data);
        return $pdf->download('reporte_nomina_general.pdf');
    }

    public function exportarExcel(Request $request)
    {
        return Excel::download(new ReporteNominaExport($request), 'reporte_nomina_general.xlsx');
    }
}
