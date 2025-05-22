<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\ConceptoSalarial;
use App\Services\LiquidacionService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LiquidacionController extends Controller
{
    protected $liquidacionService;

    public function __construct(LiquidacionService $liquidacionService)
    {
        $this->liquidacionService = $liquidacionService;
    }

    /**
     * Liquidación individual - lista paginada de empleados que no tienen liquidación para el periodo dado
     */
    public function individual(Request $request)
    {
        $periodo = $request->get('periodo', Carbon::now()->format('Y-m'));

        $empleados = Empleado::whereDoesntHave('liquidacionDetalles', function ($query) use ($periodo) {
            $query->whereHas('cabecera', function ($q) use ($periodo) {
                $q->where('periodo', $periodo);
            });
        })
        ->withCount(['hijos as hijos_menores_18_count' => function ($query) {
            $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
        }])
        ->paginate(10);

        return view('liquidaciones.individual', compact('empleados', 'periodo'));
    }

    /**
     * Mostrar detalle de liquidación de un empleado
     */
    public function show(Empleado $empleado)
    {
        $detalle = $this->liquidacionService->calcularLiquidacion($empleado);

        return view('liquidaciones.show', compact('empleado', 'detalle'));
    }

    /**
     * Guardar liquidación individual para un empleado
     */
    public function liquidar(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'montos' => 'required|array',
            'montos.*' => 'numeric|min:0',
            'periodo' => 'required|date_format:Y-m',
        ]);

        $this->liquidacionService->guardarLiquidacion($empleado, $validated['montos'], $validated['periodo']);

        return redirect()->route('liquidaciones.individual', ['periodo' => $validated['periodo']])
            ->with('success', 'Liquidación guardada correctamente.');
    }

    /**
     * Vista para liquidación total: lista todos los empleados sin liquidación en el periodo
     */
    public function total(Request $request)
    {
        $periodo = $request->get('periodo', Carbon::now()->format('Y-m'));

        $empleados = Empleado::whereDoesntHave('liquidacionDetalles', function ($query) use ($periodo) {
                $query->whereHas('cabecera', function ($q) use ($periodo) {
                    $q->where('periodo', $periodo);
                });
            })
            ->withCount(['hijos as hijos_menores_18_count' => function ($query) {
                $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
            }])
            ->get();

        return view('liquidaciones.total', compact('empleados', 'periodo'));
    }

    /**
     * Procesar y guardar liquidación total para todos los empleados
     */
    public function liquidarTotal(Request $request)
    {
        $validated = $request->validate([
            'periodo' => 'required|date_format:Y-m',
        ]);

        $periodo = $validated['periodo'];

        $this->liquidacionService->liquidarTodos($periodo);

        return redirect()->route('liquidaciones.total', ['periodo' => $periodo])
            ->with('success', 'Liquidación total guardada correctamente.');
    }

    /**
     * Vista de liquidación personalizada: formulario para asignar montos a empleados y conceptos
     */
    public function personalizado()
    {
        $empleados = Empleado::withCount(['hijos as hijos_menores_18_count' => function ($query) {
            $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
        }])->paginate(10);

        $conceptos = ConceptoSalarial::all();

        return view('liquidaciones.personalizado', compact('empleados', 'conceptos'));
    }

    /**
     * Procesar liquidación personalizada para un empleado con montos asignados manualmente
     */
    public function liquidarPersonalizado(Request $request)
    {
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id_empleado',
            'montos' => 'required|array',
            'montos.*' => 'numeric|min:0',
            'periodo' => 'required|date_format:Y-m',
        ]);

        $empleado = Empleado::findOrFail($validated['empleado_id']);

        $this->liquidacionService->guardarLiquidacion($empleado, $validated['montos'], $validated['periodo']);

        return redirect()->route('liquidaciones.personalizado')
            ->with('success', 'Liquidación personalizada guardada correctamente.');
    }

    /**
     * Empleados que no tienen liquidación para un periodo específico (paginado)
     */
    public function empleadosPorPeriodo(Request $request)
    {
        $request->validate([
            'periodo' => 'required|date_format:Y-m',
        ]);

        $periodo = $request->periodo;

        $empleadosFaltantes = Empleado::whereDoesntHave('liquidacionDetalles', function ($query) use ($periodo) {
            $query->whereHas('cabecera', function ($q) use ($periodo) {
                $q->where('periodo', $periodo);
            });
        })
        ->withCount(['hijos as hijos_menores_18_count' => function ($q) {
            $q->where('fecha_nacimiento', '>', now()->subYears(18));
        }])
        ->paginate(10);

        return view('liquidaciones.empleados_por_periodo', compact('empleadosFaltantes', 'periodo'));
    }
}
