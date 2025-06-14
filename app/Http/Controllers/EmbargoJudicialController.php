<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmbargoJudicial;
use App\Models\Empleado;

class EmbargoJudicialController extends Controller
{
    public function index()
    {
        $embargos = EmbargoJudicial::with('empleado')->latest()->get();
        return view('embargos.index', compact('embargos'));
    }
    public function create()
    {
        $empleados = Empleado::orderBy('nombre')->get();
        return view('embargos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'empleado_id' => 'required|exists:empleados,id_empleado',
            'monto_total' => 'required|numeric|min:0',
            'cuota_mensual' => 'required|numeric|min:0',
        ]);

        EmbargoJudicial::create([
            'empleado_id' => $request->empleado_id,
            'monto_total' => $request->monto_total,
            'cuota_mensual' => $request->cuota_mensual,
            'monto_restante' => $request->monto_total,
            'activo' => true,
        ]);

        return redirect()->route('embargos')->with('success', 'Embargo registrado.');
    }
}
