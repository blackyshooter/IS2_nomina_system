<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoloAdministrador
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol == 'Administrador') {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Acceso no autorizado.');
    }
}
