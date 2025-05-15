<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Carbon\Carbon; // Importar Carbon para trabajar con fechas

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::withCount('hijos')
            ->withCount(['hijos as hijos_menores_18_count' => function ($query) {
                $query->where('fecha_nacimiento', '>', Carbon::now()->subYears(18));
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
            'correo' => 'required|email|unique:empleados,correo',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'hijos' => 'nullable|array',
            'hijos.*.nombre' => 'required_with:hijos|string|max:255',
            'hijos.*.fecha_nacimiento' => 'required_with:hijos|date',
        ]);

        // Crear empleado
        $empleado = Empleado::create($request->only([
            'nombre', 'apellido', 'fecha_ingreso', 'cedula', 'correo', 'telefono', 'fecha_nacimiento'
        ]));

        // Si vienen hijos, crear cada uno asociado
        if ($request->has('hijos')) {
            foreach ($request->hijos as $hijoData) {
                $empleado->hijos()->create($hijoData);
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

    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'fecha_ingreso' => 'required|date',
            'cedula' => 'required|string|unique:empleados,cedula,' . $empleado->id_empleado,
            'correo' => 'required|email|unique:empleados,correo,' . $empleado->id_empleado,
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'required|date',
            'hijos' => 'nullable|array',
            'hijos.*.nombre' => 'required_with:hijos|string|max:255',
            'hijos.*.fecha_nacimiento' => 'required_with:hijos|date',
        ]);

        // Actualizar empleado
        $empleado->update($request->only([
            'nombre', 'apellido', 'fecha_ingreso', 'cedula', 'correo', 'telefono', 'fecha_nacimiento'
        ]));

        // Actualizar hijos: eliminar todos y crear de nuevo
        if ($request->has('hijos')) {
            $empleado->hijos()->delete();
            foreach ($request->hijos as $hijoData) {
                $empleado->hijos()->create($hijoData);
            }
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente');
    }

    public function destroy(Empleado $empleado)
    {
        // Primero borrar hijos para evitar error FK
        $empleado->hijos()->delete();
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente');
    }
}
