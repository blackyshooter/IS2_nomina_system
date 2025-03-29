<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Persona;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::with('persona')->get();
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
        ]);

        // Crear persona
        $persona = Persona::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        // Crear empleado
        Empleado::create([
            'cedula' => $request->cedula,
            'telefono' => $request->telefono,
            'sueldo_base' => $request->sueldo_base,
            'fecha_ingreso' => $request->fecha_ingreso,
            'cargo' => $request->cargo,
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado creado correctamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::with('persona')->findOrFail($id);
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

        // Actualizar persona
        $persona->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);

        // Actualizar empleado
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
        $empleado->persona->delete(); // borra persona asociada
        $empleado->delete(); // borra empleado

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado correctamente.');
    }
}

