<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Services\LiquidacionService;

class LiquidacionController extends Controller
{
    protected $servicio;

    public function __construct(LiquidacionService $servicio)
    {
        $this->servicio = $servicio;
    }

    public function mostrar($id)
    {
        $empleado = Empleado::with('hijos')->findOrFail($id);
        $conceptos = $this->servicio->calcular($empleado);

        return view('liquidacion.show', compact('empleado', 'conceptos'));
    }
}
