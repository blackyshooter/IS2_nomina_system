<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    public function index()
    {
        //
    }

    public function aplicarDescuentosAutomaticos()
{
    $descuentos = ConceptoEmpleado::whereNotNull('fecha_inicio')
        ->whereNull('fecha_fin')
        ->orWhere('fecha_fin', '>', now())
        ->get();

    foreach ($descuentos as $descuento) {
        if ($descuento->monto_total && $descuento->monto_mensual) {
            // Verificar si ya se alcanzó el monto total
            $totalAplicado = DetalleLiquidacion::where('empleado_id', $descuento->empleado_id)
                ->where('concepto_id', $descuento->concepto_id)
                ->sum('monto');

            if ($totalAplicado >= $descuento->monto_total) {
                continue;
            }

            // Aplicar el descuento en la liquidación actual
            DetalleLiquidacion::create([
                'liquidacion_id' => $this->obtenerLiquidacionActual(),
                'empleado_id' => $descuento->empleado_id,
                'concepto_id' => $descuento->concepto_id,
                'monto' => min($descuento->monto_mensual, $descuento->monto_total - $totalAplicado),
            ]);
        }
    }
}

private function obtenerLiquidacionActual()
{
    return LiquidacionCabecera::where('fecha_liquidacion', '>=', now()->startOfMonth())
        ->where('fecha_liquidacion', '<=', now()->endOfMonth())
        ->first()->id_liquidacion ?? null;
}

    public function store(Request $request)
    {
        ConceptoSalarial::create($request->all());
        return redirect()->route('descuentos.index')->with('success', 'Descuento creado correctamente.');
    }

    public function update(Request $request, ConceptoSalarial $descuento)
    {
        $descuento->update($request->all());
        return redirect()->route('descuentos.index')->with('success', 'Descuento actualizado.');
    }

    public function destroy(ConceptoSalarial $descuento)
    {
        $descuento->delete();
        return redirect()->route('descuentos.index')->with('success', 'Descuento eliminado.');
    }

    
}
