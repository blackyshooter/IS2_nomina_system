<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'contraseña' => 'required'
        ]);

        $user = Usuario::where('email', $request->email)->first();

        if ($user && Hash::check($request->contraseña, $user->contraseña)) {
            Auth::login($user);
            return redirect()->route('empleados.index');
        }

        return back()->with('error', 'Credenciales incorrectas');
    }

     
    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:usuario,email',
            'cedula' => 'required|numeric|unique:personas,cedula',
            'nombre' => 'required',
            'apellido' => 'required',
            'contraseña' => 'required|min:6'
        ]);

        // Crear persona
        \App\Models\Persona::create([
            'cedula' => $request->cedula,
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'fecha_nacimiento' => now() // temporal
        ]);

        // Crear usuario
        Usuario::create([
            'email' => $request->email,
            'nombre_usuario' => $request->nombre,
            'contraseña' => Hash::make($request->contraseña),
            'id_empleado' => null
        ]);

        return redirect()->route('login')->with('success', 'Cuenta creada correctamente. Inicia sesión.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
