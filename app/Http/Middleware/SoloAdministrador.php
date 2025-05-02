<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SoloAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (Auth::check() && optional(Auth::user()->rol)->nombre_rol === 'Administrador') {
        return $next($request);
    }

    return redirect()->route('/')->with('error', 'Acceso no autorizado');
}

}
