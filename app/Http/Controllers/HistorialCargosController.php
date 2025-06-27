<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HistorialCargo;
use App\Models\Empleado;

class HistorialCargosController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $cargos = HistorialCargo::with(['empleado', 'cargo'])
            ->when($busqueda, function ($query, $busqueda) {
                $query->whereHas('empleado', function ($q) use ($busqueda) {
                    $q->where('nombre', 'ILIKE', "%{$busqueda}%")
                      ->orWhere('apellido', 'ILIKE', "%{$busqueda}%")
                      ->orWhere('cedula', 'ILIKE', "%{$busqueda}%");
                });
            })
            ->orderByDesc('fecha_inicio')
            ->paginate(10)
            ->withQueryString();

        return view('historial_cargos.index', compact('cargos', 'busqueda'));
    }
}
