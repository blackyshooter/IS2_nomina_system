<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloAdministrador
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && optional(Auth::user()->rol)->nombre_rol === 'Administrador') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Acceso no autorizado.');
    }
}

