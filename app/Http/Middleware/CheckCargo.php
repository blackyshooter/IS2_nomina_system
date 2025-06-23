<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCargo
{
    public function handle(Request $request, Closure $next, ...$cargosPermitidos): Response
    {
        $empleado = auth()->user()->empleado ?? null;

        if (!$empleado || !in_array($empleado->cargo, $cargosPermitidos)) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
