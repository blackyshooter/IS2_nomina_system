<?php

namespace App\Http\Controllers;

use App\Models\Ausencia;
use App\Models\Empleado; // Necesitas el modelo Empleado para el dropdown
use Illuminate\Http\Request;
use Carbon\Carbon; // Para calcular días entre fechas

class AusenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ausencias = Ausencia::with('empleado')->latest()->get();
        return view('ausencias.index', compact('ausencias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleados = Empleado::orderBy('nombre')->get(); // Obtener todos los empleados
        return view('ausencias.create', compact('empleados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo_ausencia' => 'required|string|in:justificada,injustificada,vacaciones,enfermedad',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $diasAusente = $fechaInicio->diffInDays($fechaFin) + 1; // Sumar 1 para incluir el día de inicio y fin

        Ausencia::create([
            'empleado_id' => $request->empleado_id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'dias_ausente' => $diasAusente,
            'tipo_ausencia' => $request->tipo_ausencia,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('ausencias.index')->with('success', 'Ausencia registrada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ausencia $ausencia)
    {
        // Puedes implementar una vista para ver detalles de una ausencia
        // return view('ausencias.show', compact('ausencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ausencia $ausencia)
    {
        $empleados = Empleado::orderBy('nombre')->get();
        return view('ausencias.edit', compact('ausencia', 'empleados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ausencia $ausencia)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'tipo_ausencia' => 'required|string|in:justificada,injustificada,vacaciones,enfermedad',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);
        $diasAusente = $fechaInicio->diffInDays($fechaFin) + 1;

        $ausencia->update([
            'empleado_id' => $request->empleado_id,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'dias_ausente' => $diasAusente,
            'tipo_ausencia' => $request->tipo_ausencia,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('ausencias.index')->with('success', 'Ausencia actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ausencia $ausencia)
    {
        $ausencia->delete();
        return redirect()->route('ausencias.index')->with('success', 'Ausencia eliminada exitosamente.');
    }
}