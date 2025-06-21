<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::withCount('hijos')
            ->withCount(['hijos as hijos_menores_18_count' => function ($query) {
                $query->where('fecha_nacimiento', '>', Carbon::today()->subYears(18));
            }])
            ->paginate(10);

        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'cedula' => 'required|string|unique:empleados,cedula',
            'correo' => 'nullable|email|unique:empleados,correo',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'cargo' => 'required|string|max:255',
            'salario_base' => 'required|numeric|min:0',
            'hijos' => 'nullable|array',
            'hijos.*.nombre' => 'required_with:hijos|string|max:255',
            'hijos.*.apellido' => 'required_with:hijos|string|max:255',
            'hijos.*.fecha_nacimiento' => 'required_with:hijos|date',
        ]);

        $empleado = Empleado::create($request->only([
            'nombre', 'apellido', 'fecha_ingreso', 'cedula', 'correo', 'telefono', 'fecha_nacimiento', 'salario_base'
        ]));

        if ($request->filled('hijos')) {
            $hijosFiltrados = collect($request->input('hijos'))->filter(function ($hijo) {
                return !empty($hijo['nombre']) && !empty($hijo['apellido']) && !empty($hijo['fecha_nacimiento']);
            });

            foreach ($hijosFiltrados as $hijoData) {
                $empleado->hijos()->create([
                    'nombre' => $hijoData['nombre'],
                    'apellido' => $hijoData['apellido'],
                    'fecha_nacimiento' => $hijoData['fecha_nacimiento'],
                ]);
            }
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente');
    }

    public function show(Empleado $empleado)
    {
        $empleado->load('hijos');
        return view('empleados.show', compact('empleado'));
    }

    public function edit($id)
    {
        $empleado = Empleado::with('hijos')->findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'hijos.*.nombre' => 'nullable|string|max:255',
            'hijos.*.apellido' => 'nullable|string|max:255',
            'hijos.*.fecha_nacimiento' => 'nullable|date',
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
        ]);

        $idsEnviados = collect($request->hijos)->pluck('id')->filter()->toArray();

        // Eliminar hijos no incluidos
        $empleado->hijos()->whereNotIn('id', $idsEnviados)->delete();

        if ($request->has('hijos')) {
            foreach ($request->hijos as $hijo) {
                if (isset($hijo['id'])) {
                    // Actualizar
                    $empleado->hijos()->where('id', $hijo['id'])->update([
                        'nombre' => $hijo['nombre'],
                        'apellido' => $hijo['apellido'],
                        'fecha_nacimiento' => $hijo['fecha_nacimiento'],
                    ]);
                } else {
                    // Crear
                    $empleado->hijos()->create([
                        'nombre' => $hijo['nombre'],
                        'apellido' => $hijo['apellido'],
                        'fecha_nacimiento' => $hijo['fecha_nacimiento'],
                    ]);
                }
            }
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy(Empleado $empleado)
    {
        $empleado->hijos()->delete();
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
    }

    public function listarParaLiquidacion()
    {
        $empleados = Empleado::withCount(['hijos as hijos_menores_18_count' => function ($query) {
            $query->where('fecha_nacimiento', '>', now()->subYears(18));
        }])
        ->select('id_empleado', 'nombre', 'apellido', 'salario_base')
        ->paginate(10);

        return view('liquidaciones.individual', compact('empleados'));
    }
}
