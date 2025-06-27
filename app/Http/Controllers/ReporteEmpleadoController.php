<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cargo;
use App\Models\HistorialCargo;
use App\Models\LiquidacionCabecera;
use App\Models\DetalleLiquidacion;

class ReporteEmpleadoController extends Controller
{
    public function extracto()
    {
        return redirect()->route('reportes.extracto.personal', [
            'mes' => now()->month,
            'anio' => now()->year,
        ]);
    }

    public function extractoPersonal(Request $request)
    {
        $mesSeleccionado = $request->input('mes', now()->format('m'));
        $anioSeleccionado = $request->input('anio', now()->format('Y'));

        $empleado = auth()->user()->empleado;

        // Obtener solo una liquidación para el mes/año y el empleado autenticado
        $liquidacion = $empleado->liquidacionCabeceras()
            ->whereMonth('fecha_liquidacion', $mesSeleccionado)
            ->whereYear('fecha_liquidacion', $anioSeleccionado)
            ->with(['detalles.concepto']) 
            ->first();

        if (!$liquidacion) {
            return back()->with('error', 'No se encontró liquidación para el periodo seleccionado.');
        }

        return view('reportes.extracto_personal', [
            'liquidacion' => $liquidacion,
            'empleado' => $empleado,
            'mesSeleccionado' => $mesSeleccionado,
            'anioSeleccionado' => $anioSeleccionado,
        ]);
    }

    public function imprimirExtracto(Request $request)
    {
        $mesSeleccionado = $request->input('mes', now()->format('m'));
        $anioSeleccionado = $request->input('anio', now()->format('Y'));

        $empleado = auth()->user()->empleado;

        $liquidacion = $empleado->liquidacionCabeceras()
            ->whereMonth('fecha_liquidacion', $mesSeleccionado)
            ->whereYear('fecha_liquidacion', $anioSeleccionado)
            ->with(['detalles.concepto'])
            ->first();

        if (!$liquidacion) {
            return back()->with('error', 'No se encontró liquidación para el periodo seleccionado.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.extracto_personal_pdf', [
            'liquidacion' => $liquidacion,
            'empleado' => $empleado,
            'mesSeleccionado' => $mesSeleccionado,
            'anioSeleccionado' => $anioSeleccionado,
        ]);

        return $pdf->stream('extracto_personal.pdf');
    }

    

    public function embargos()
    {
        return view('reportes.embargos_personales');
    }

    public function generarEmbargos(Request $request)
    {
        $empleado = Auth::user()->empleado;
        $anio = $request->input('anio');

        $embargos = $empleado->embargoJudicial()
            ->whereYear('created_at', $anio)
            ->get();

        return view('reportes.embargos_personales', compact('embargos'));
    }


    public function imprimirEmbargos(Request $request)
    {
        $empleado = Auth::user()->empleado;
        $anio = $request->input('anio');

        $embargos = $empleado->embargoJudicial()
            ->whereYear('created_at', $anio)
            ->get();

        $pdf = PDF::loadView('reportes.embargos_personales_pdf', compact('empleado', 'embargos'));

        return $pdf->download('embargos_personales.pdf');
    }


    public function datosPersonales()
    {
        $empleado = auth()->user()->empleado;

        $usuarioAsignado = $empleado->usuario ?? null;

        $historial = $empleado->historialCargos()
            ->with('cargo')
            ->orderByDesc('fecha_inicio')
            ->get();

        $cargoActual = $historial->firstWhere('fecha_fin', null)?->cargo->nombre ?? 'Sin asignar';

        $salarioBase = $empleado->salario_base ?? 0;

        $fechaIngreso = $empleado->created_at;
        $antiguedad = $fechaIngreso ? now()->diff($fechaIngreso) : null;

        return view('reportes.datos_personales', compact(
            'empleado',
            'usuarioAsignado',
            'cargoActual',
            'historial',
            'salarioBase',
            'antiguedad'
        ));
    }
    //recibos de pago
    public function vistaRecibos(Request $request)
    {
        $periodo = $request->input('periodo', now()->format('Y-m'));
        $busqueda = $request->input('busqueda');

        $query = Empleado::with('usuario');

        if ($busqueda) {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'ILIKE', "%{$busqueda}%")
                ->orWhere('cedula', 'ILIKE', "%{$busqueda}%");
            });
        }

        $empleados = $query->paginate(10)->withQueryString();

        $periodoFormateado = \Carbon\Carbon::createFromFormat('Y-m', $periodo)->translatedFormat('F Y');

        $estados = [];
        foreach ($empleados as $empleado) {
            $existe = LiquidacionCabecera::where('periodo', $periodo)
                ->whereHas('detalles', function ($q) use ($empleado) {
                    $q->where('empleado_id', $empleado->id_empleado);
                })->exists();
            $estados[$empleado->id_empleado] = $existe;
        }

        return view('reportes.lista_recibos', compact(
            'empleados',
            'periodo',
            'busqueda',
            'periodoFormateado',
            'estados'
        ));
    }


    public function generarReciboPago($id_empleado, $periodo)
    {
        $empleado = Empleado::with('hijos')->findOrFail($id_empleado);

        $liquidacion = LiquidacionCabecera::where('periodo', $periodo)
            ->whereHas('detalles', function ($query) use ($id_empleado) {
                $query->where('empleado_id', $id_empleado);
            })->firstOrFail();

        $detalles = DetalleLiquidacion::where('liquidacion_id', $liquidacion->id_liquidacion)
            ->where('empleado_id', $id_empleado)
            ->with('concepto')
            ->get();

        $periodoFormateado = Carbon::createFromFormat('Y-m', $periodo)->translatedFormat('F Y');

        $data = compact('empleado', 'periodo', 'periodoFormateado', 'liquidacion', 'detalles');

        $pdf = Pdf::loadView('reportes.recibo_pago', $data);
        return $pdf->stream("recibo_{$empleado->nombre}_{$periodo}.pdf");
    }


}
