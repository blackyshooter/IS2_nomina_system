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

    // Liquidación individual - lista paginada
    public function individual()
    {
        $empleados = Empleado::withCount(['hijos as hijos_menores_18_count' => function ($query) {
            $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
        }])->paginate(10);

        return view('liquidaciones.individual', compact('empleados'));
    }

    // Mostrar detalle liquidación de un empleado
    public function show(Empleado $empleado)
    {
        $detalle = $this->liquidacionService->calcularLiquidacion($empleado);

        return view('liquidaciones.show', compact('empleado', 'detalle'));
    }

    // Guardar liquidación individual
    public function liquidar(Request $request, Empleado $empleado)
    {
        $validated = $request->validate([
            'montos' => 'required|array',
            'montos.*' => 'numeric|min:0',
        ]);

        $this->liquidacionService->guardarLiquidacion($empleado, $validated['montos']);

        return redirect()->route('liquidaciones.individual')->with('success', 'Liquidación guardada correctamente.');
    }

    // Liquidación total - lista todos empleados sin paginar (o puedes paginar si prefieres)
    public function total()
    {
        $empleados = Empleado::withCount(['hijos as hijos_menores_18_count' => function ($query) {
            $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
        }])->get();

        // También puedes calcular resumen global o lo que necesites mostrar
        return view('liquidaciones.total', compact('empleados'));
    }

    // Procesar liquidación total para todos los empleados
    public function liquidarTotal(Request $request)
    {
        // Aquí podrías validar si envías montos personalizados, o simplemente liquidar con valores calculados
        // Por ejemplo, llamar a un método que liquide todos con cálculos automáticos
        $this->liquidacionService->liquidarTodos();

        return redirect()->route('liquidaciones.total')->with('success', 'Liquidación total guardada correctamente.');
    }

    // Liquidación personalizado - formulario para elegir empleados y ajustar montos
    public function personalizado()
    {
        $empleados = Empleado::withCount(['hijos as hijos_menores_18_count' => function ($query) {
            $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
        }])->paginate(10);

        // Carga conceptos para mostrar en el formulario personalizado
        $conceptos = ConceptoSalarial::all();

        return view('liquidaciones.personalizado', compact('empleados', 'conceptos'));
    }

    // Procesar liquidación personalizado
    public function liquidarPersonalizado(Request $request)
    {
        $validated = $request->validate([
            'empleado_id' => 'required|exists:empleados,id_empleado',
            'montos' => 'required|array',
            'montos.*' => 'numeric|min:0',
        ]);

        $empleado = Empleado::findOrFail($validated['empleado_id']);

        $this->liquidacionService->guardarLiquidacion($empleado, $validated['montos']);

        return redirect()->route('liquidaciones.personalizado')->with('success', 'Liquidación personalizada guardada correctamente.');
    }

    //filtro
    // En LiquidacionController.php

    public function empleadosPorPeriodo(Request $request)
    {
    $request->validate([
        'periodo' => 'required|date_format:Y-m', // Asegura que el periodo venga en formato YYYY-MM
    ]);

    $periodo = $request->periodo;

    // Obtener empleados que NO tienen liquidación para ese período
    $empleadosFaltantes = Empleado::whereDoesntHave('liquidacionCabecera', function ($query) use ($periodo) {
        $query->where('periodo', $periodo);
    })
    ->withCount(['hijos as hijos_menores_18_count' => function ($q) {
        $q->where('fecha_nacimiento', '>', now()->subYears(18));
    }])
    ->paginate(10);

    return view('liquidaciones.empleados_por_periodo', compact('empleadosFaltantes', 'periodo'));
    }

}
