<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;

class AsignarRolController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('roles')->get();
        $roles = Rol::all();
        return view('asignar_roles.index', compact('usuarios', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuario,id',
            'roles' => 'required|array',
        ]);

        $usuario = Usuario::find($request->usuario_id);
        $usuario->roles()->sync($request->roles);

        return redirect()->route('asignar_roles.index')->with('success', 'Roles asignados correctamente.');
    }
}
