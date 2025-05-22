<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('empleado')->paginate(10);
        return view('usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('usuarios.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'nombre_usuario' => 'required|string|max:255',
            'id_empleado' => 'required|exists:empleados,id_empleado',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nombre_usuario' => $request->nombre_usuario,
            'id_empleado' => $request->id_empleado,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit(User $usuario)
    {
        $empleados = Empleado::all();
        return view('usuarios.edit', compact('usuario', 'empleados'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|min:6|confirmed',
            'nombre_usuario' => 'required|string|max:255',
            'id_empleado' => 'required|exists:empleados,id_empleado',
        ]);

        $usuario->email = $request->email;
        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->id_empleado = $request->id_empleado;

        if (trim($request->password) !== '') {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
