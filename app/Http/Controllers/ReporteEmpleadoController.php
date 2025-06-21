<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empleado;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


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
            ->with(['detalles.concepto']) // eager load para evitar N+1
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
        $empleado = Auth::user()->empleado->load(['usuario', 'cargo']);
        return view('reportes.datos_personales', compact('empleado'));
    }
}
