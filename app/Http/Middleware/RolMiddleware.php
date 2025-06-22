<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        // Admite varios roles: role:admin,asistente
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Si no tiene permiso, mensaje de error 403
        abort(403, 'No tiene permiso para acceder a esta sección.');
    }
}


