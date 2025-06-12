<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Empleado; // Necesitas el modelo Empleado para el dropdown
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    /**
     * Muestra una lista de los préstamos.
     */
    public function index()
    {
        // Carga los préstamos y sus empleados asociados para mostrarlos en la tabla
        $prestamos = Prestamo::with('empleado')->latest()->get();
        return view('prestamos.index', compact('prestamos'));
    }

    /**
     * Muestra el formulario para crear un nuevo préstamo.
     */
    public function create()
    {
        // Obtiene todos los empleados para el selector del formulario
        $empleados = Empleado::orderBy('nombre')->get();
        return view('prestamos.create', compact('empleados'));
    }

    /**
     * Almacena un nuevo préstamo en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada del formulario
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id_empleado', // Asegúrate de que 'id_empleado' sea la clave primaria de tu tabla empleados
            'monto_total' => 'required|numeric|min:0.01',
            'monto_cuota' => 'required|numeric|min:0.01|lte:monto_total', // La cuota no puede ser mayor al monto total
            'fecha_inicio_pago' => 'required|date',
            'descripcion' => 'nullable|string|max:500',
        ], [
            'monto_cuota.lte' => 'El monto de la cuota no puede ser mayor que el monto total del préstamo.'
        ]);

        // Calcula las cuotas restantes
        $cuotasRestantes = ceil($request->monto_total / $request->monto_cuota);

        // Crea el nuevo registro de préstamo
        Prestamo::create([
            'empleado_id' => $request->empleado_id,
            'monto_total' => $request->monto_total,
            'monto_cuota' => $request->monto_cuota,
            'cuotas_restantes' => $cuotasRestantes,
            'fecha_inicio_pago' => Carbon::parse($request->fecha_inicio_pago),
            'descripcion' => $request->descripcion,
            'activo' => true, // Por defecto, el préstamo está activo
        ]);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo registrado exitosamente.');
    }

    /**
     * Muestra los detalles de un préstamo específico.
     */
    public function show(Prestamo $prestamo)
    {
        // Opcional: Implementa una vista para ver los detalles de un préstamo
        return view('prestamos.show', compact('prestamo'));
    }

    /**
     * Muestra el formulario para editar un préstamo existente.
     */
    public function edit(Prestamo $prestamo)
    {
        $empleados = Empleado::orderBy('nombre')->get();
        return view('prestamos.edit', compact('prestamo', 'empleados'));
    }

    /**
     * Actualiza un préstamo existente en la base de datos.
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        $request->validate([
            'empleado_id' => 'required|exists:empleados,id_empleado',
            'monto_total' => 'required|numeric|min:0.01',
            'monto_cuota' => 'required|numeric|min:0.01|lte:monto_total',
            'cuotas_restantes' => 'required|integer|min:0', // Permite actualizar cuotas restantes manualmente
            'fecha_inicio_pago' => 'required|date',
            'descripcion' => 'nullable|string|max:500',
            'activo' => 'boolean',
        ], [
            'monto_cuota.lte' => 'El monto de la cuota no puede ser mayor que el monto total del préstamo.'
        ]);

        $prestamo->update([
            'empleado_id' => $request->empleado_id,
            'monto_total' => $request->monto_total,
            'monto_cuota' => $request->monto_cuota,
            'cuotas_restantes' => $request->cuotas_restantes,
            'fecha_inicio_pago' => Carbon::parse($request->fecha_inicio_pago),
            'descripcion' => $request->descripcion,
            'activo' => $request->boolean('activo'),
        ]);

        return redirect()->route('prestamos.index')->with('success', 'Préstamo actualizado exitosamente.');
    }

    /**
     * Elimina un préstamo de la base de datos.
     */
    public function destroy(Prestamo $prestamo)
    {
        $prestamo->delete();
        return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado exitosamente.');
    }
}