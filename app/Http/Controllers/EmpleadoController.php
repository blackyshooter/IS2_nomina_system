<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Persona;
use App\Models\Hijo;
use Carbon\Carbon;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('persona', 'hijos')->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cedula' => 'required|numeric|unique:personas,cedula',
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:25',
            'sueldo_base' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'cargo' => 'required|string|max:25',
            'hijos' => 'array',
            'hijos.*.nombre' => 'required|string|max:25',
            'hijos.*.apellido' => 'required|string|max:25',
            'hijos.*.fecha_nacimiento' => 'required|date',
        ]);

        // Crear persona
        $persona = Persona::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        // Crear empleado
        $empleado = Empleado::create([
            'cedula' => $persona->cedula,
            'telefono' => $request->telefono,
            'sueldo_base' => $request->sueldo_base,
            'fecha_ingreso' => $request->fecha_ingreso,
            'cargo' => $request->cargo,
        ]);

        // Crear hijos, si los hay
        if ($request->has('hijos')) {
            foreach ($request->hijos as $hijoData) {
                $empleado->hijos()->create([
                    'nombre' => $hijoData['nombre'],
                    'apellido' => $hijoData['apellido'],
                    'fecha_nacimiento' => $hijoData['fecha_nacimiento'],
                ]);
            }
        }

        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::with('persona', 'hijos')->findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);
        $persona = $empleado->persona;

        $request->validate([
            'nombre' => 'required|string|max:25',
            'apellido' => 'required|string|max:25',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:25',
            'sueldo_base' => 'required|numeric|min:0',
            'fecha_ingreso' => 'required|date',
            'cargo' => 'required|string|max:25',
        ]);

        $persona->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        $empleado->update([
            'telefono' => $request->telefono,
            'sueldo_base' => $request->sueldo_base,
            'fecha_ingreso' => $request->fecha_ingreso,
            'cargo' => $request->cargo,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->persona->delete();
        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }

    public function reporte()
    {
        $empleados = Empleado::with(['persona', 'hijos'])->get();

        foreach ($empleados as $empleado) {
            $hijosMenores = $empleado->hijos->filter(function ($hijo) {
                return Carbon::parse($hijo->fecha_nacimiento)->age < 18;
            })->count();

            $empleado->hijos_menores = $hijosMenores;
        }

        return view('empleados.reporte', compact('empleados'));
    }
}
