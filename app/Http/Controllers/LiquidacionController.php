<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Services\LiquidacionService;
use Illuminate\Http\Request;

class LiquidacionController extends Controller
{
    protected $servicio;

    public function __construct(LiquidacionService $servicio)
    {
        $this->servicio = $servicio;
    }

    /**
     * Muestra el formulario de búsqueda de liquidaciones.
     */
    public function index()
    {
        return view('liquidacion.index');
    }

    /**
     * Calcula y muestra la liquidación de un empleado.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function calcular(Request $request)
    {
        // Validar que se haya enviado un ID
        $request->validate([
            'id' => 'required|integer|exists:empleados,id_empleado',
        ]);

        // Buscar el empleado con sus datos relacionados
        $empleado = Empleado::with('persona')->find($request->input('id'));

        // Si no se encuentra el empleado, redirigir con un mensaje de error
        if (!$empleado) {
            return redirect()->route('liquidaciones.index')->with('error', 'Empleado no encontrado.');
        }

        // Calcular los conceptos de la liquidación
        try {
            $conceptos = $this->servicio->calcular($empleado);
        } catch (\Exception $e) {
            // Manejar errores del servicio de liquidación
            return redirect()->route('liquidaciones.index')->with('error', 'Error al calcular la liquidación: ' . $e->getMessage());
        }

        // Retornar la vista con los datos del empleado y los conceptos calculados
        return view('liquidacion.show', compact('empleado', 'conceptos'));
    }
}
