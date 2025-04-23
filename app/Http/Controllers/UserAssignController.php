<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class UserAssignController extends Controller {

    public function asignarUsuario(Request $request, $empleado_id)
    {
        $empleado = Empleado::findOrFail($empleado_id);

        $passwordPlano = Str::random(10); // Podés mostrar esto solo una vez
        $idUsuario = 'USR' . rand(1000, 9999);

        $usuario = Usuario::create([
            'name' => $empleado->nombre,
            'email' => $empleado->correo,
            'id_usuario' => $idUsuario,
            'password' => Hash::make($passwordPlano),
            'rol' => $request->rol,
            'empleado_id' => $empleado->id,
        ]);

        return redirect()->back()->with('success', 'Usuario creado. Contraseña temporal: ' . $passwordPlano);
    }
}