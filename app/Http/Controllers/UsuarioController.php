<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Cargo;
use App\Models\HistorialCargo;
use Carbon\Carbon;




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
        'empleado_id' => 'required|exists:empleados,id_empleado',
        'nombre_usuario' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed',
        'cargo' => 'required|in:Administrador,Gerente/RRHH,Asistente de RRHH,Empleado',
    ]);

    // Crear usuario
    $usuario = User::create([
        'id_empleado' => $request->empleado_id,
        'nombre_usuario' => $request->nombre_usuario,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Buscar el cargo por nombre
    $cargo = Cargo::where('nombre', $request->cargo)->first();

    // Insertar historial de cargo
    if ($cargo) {
        HistorialCargo::create([
            'empleado_id' => $request->empleado_id,
            'cargo_id' => $cargo->id,
            'fecha_inicio' => Carbon::now()->toDateString(),
        ]);
    }

    return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
}

    public function edit(User $usuario)
    {
        $empleados = Empleado::all();
        return view('usuarios.edit', compact('usuario', 'empleados'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $usuario->id_usuario . ',id_usuario',
            'password' => 'nullable|string|confirmed|min:6',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'cargo' => 'required|string',
        ]);

        $usuario->nombre_usuario = $request->nombre_usuario;
        $usuario->email = $request->email;
        $usuario->id_empleado = $request->id_empleado;

        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->password);
        }

        $usuario->save();

        $empleado = Empleado::findOrFail($request->id_empleado);

        // Verificar si cambió el cargo
        if ($empleado->cargo !== $request->cargo) {
            // Cerrar historial actual
            $historialActual = HistorialCargo::where('empleado_id', $empleado->id_empleado)
                ->whereNull('fecha_fin')
                ->latest('fecha_inicio')
                ->first();

            if ($historialActual) {
                $historialActual->update(['fecha_fin' => Carbon::today()]);
            }

            // Actualizar el cargo en la tabla empleados
            $empleado->cargo = $request->cargo;
            $empleado->save();

            // Nuevo historial
            $cargo = Cargo::where('nombre', $request->cargo)->first();
            if ($cargo) {
                HistorialCargo::create([
                    'empleado_id' => $empleado->id_empleado,
                    'cargo_id' => $cargo->id,
                    'fecha_inicio' => Carbon::today(),
                ]);
            }
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }


    public function destroy(User $usuario)
    {
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }
}
