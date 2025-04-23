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

        // 🔁 Redirección según el rol
        switch ($usuario->rol) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'empleado':
                return redirect()->route('empleado.inicio');
            default:
                return redirect()->route('home');
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
