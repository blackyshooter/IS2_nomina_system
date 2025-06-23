<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Cargo;
use App\Models\HistorialCargo;


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

}
