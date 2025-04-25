<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'login' => 'required|string',
        'password' => 'required|string',
    ]);

    $usuario = Usuario::where('email', $request->login)
                      ->orWhere('id_usuario', $request->login)
                      ->first();

    if ($usuario && Hash::check($request->password, $usuario->password)) {
        Auth::login($usuario);
        
        // Verificación antes del redirect
   /* session()->put('login_test', 'OK');
    dd(Auth::check(), Auth::user(), session()->all());*/

        // Redirección según el rol
        switch (optional($usuario->rol)->nombre) {
            case 'Administrador':
                return redirect()->route('admin');
            case 'Gerente/RRHH':
                return redirect()->route('empleados.index');
            default:
                return redirect()->route('empleado.inicio');
        }
        
    }

    return back()->with('error', 'Credenciales incorrectas');
}

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
