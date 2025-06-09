<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\ConceptoEmpleado;
use PDF;

class ReciboController extends Controller
{
    public function generarRecibo($idEmpleado)
    {
        $empleado = Empleado::findOrFail($idEmpleado);
        $descuentos = ConceptoEmpleado::where('empleado_id', $idEmpleado)->get();
        
        $pdf = PDF::loadView('recibo', compact('empleado', 'descuentos'));
        return $pdf->download('recibo_pago.pdf');
    }
}