<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $roles = Rol::all();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre',
        ]);

        Rol::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Rol $rol)
    {
        return view('roles.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $rol->id,
        ]);

        $rol->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('roles.index')->with('success', 'Rol actualizado.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado.');
    }
}
