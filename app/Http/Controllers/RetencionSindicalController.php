<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetencionSindical;
use App\Models\Empleado;

class RetencionSindicalController extends Controller
{
    public function index()
    {
        $retenciones = RetencionSindical::with('empleado')->latest()->get();
        return view('retenciones.index', compact('retenciones'));
}
    public function create()
    {
        $empleados = Empleado::orderBy('nombre')->get();
        return view('retenciones.create', compact('empleados'));
    }
    public function edit($id)
    {
        $retencion = RetencionSindical::findOrFail($id);
        $empleados = Empleado::orderBy('nombre')->get();
        return view('retenciones.edit', compact('retencion', 'empleados'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id_empleado',
            'monto_mensual' => 'required|numeric|min:0',
        ]);

        $retencion = RetencionSindical::findOrFail($id);
        $retencion->update([
            'empleado_id' => $request->empleado_id,
            'monto_mensual' => $request->monto_mensual,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('retenciones.index')->with('success', 'Retención actualizada correctamente.');
    }

    public function store(Request $request)
{
    $request->validate([
        'empleado_id' => 'required|exists:empleados,id_empleado',
        'monto_mensual' => 'required|numeric|min:0',
        'activo' => 'boolean'
    ]);

    RetencionSindical::create([
        'empleado_id' => $request->empleado_id,
        'monto_mensual' => $request->monto_mensual,
        'activo' => $request->has('activo') ? $request->activo : true,
    ]);

    return redirect()->route('retenciones.index')->with('success', 'Retención registrada correctamente.');
}

}
