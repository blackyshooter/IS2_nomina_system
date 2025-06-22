<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\AusenciaController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\EmbargoJudicialController;
use App\Http\Controllers\RetencionSindicalController;
use App\Http\Controllers\ReporteEmpleadoController;

// === Página de bienvenida ===
Route::get('/', function () {
    return view('welcome');
});

// === ADMINISTRADOR ===
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD empleados
    Route::resource('empleados', EmpleadoController::class);
    Route::get('empleados/reporte', [EmpleadoController::class, 'reporte'])->name('empleados.reporte');

    // Gestión usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Gestión de ausencias, préstamos, descuentos/adicionales
    Route::resource('ausencias', AusenciaController::class);
    Route::resource('prestamos', PrestamoController::class);

    // Embargos y retenciones
    Route::prefix('descuentos')->group(function () {
        Route::get('/embargos/create', [EmbargoJudicialController::class, 'create'])->name('embargos.create');
        Route::post('/embargos', [EmbargoJudicialController::class, 'store'])->name('embargos.store');
        Route::get('/embargos', [EmbargoJudicialController::class, 'index'])->name('embargos.index');
        Route::resource('retenciones', RetencionSindicalController::class)->except(['show']);
        Route::get('/retenciones/create', [RetencionSindicalController::class, 'create'])->name('retenciones.create');
        Route::get('/retenciones/edit', [RetencionSindicalController::class, 'edit'])->name('retenciones.edit');
        Route::post('/retenciones', [RetencionSindicalController::class, 'store'])->name('retenciones.store');
        Route::get('/retenciones', [RetencionSindicalController::class, 'index'])->name('retenciones.index');
    });

    // Liquidaciones (todas las acciones)
    Route::prefix('liquidaciones')->group(function () {
        Route::get('individual', [LiquidacionController::class, 'individual'])->name('liquidaciones.individual');
        Route::get('total', [LiquidacionController::class, 'total'])->name('liquidaciones.total');
        Route::post('total/liquidar', [LiquidacionController::class, 'liquidarTotal'])->name('liquidaciones.liquidar-total');
        Route::get('personalizado', [LiquidacionController::class, 'personalizado'])->name('liquidaciones.personalizado');
        Route::post('personalizado/liquidar', [LiquidacionController::class, 'liquidarPersonalizado'])->name('liquidaciones.liquidarPersonalizado');
        Route::get('{empleado}', [LiquidacionController::class, 'show'])->name('liquidaciones.show');
        Route::post('{empleado}/liquidar', [LiquidacionController::class, 'liquidar'])->name('liquidaciones.liquidar');
    });

    // Reportes y dashboards globales
    Route::prefix('reporte')->group(function () {
        Route::get('/extracto', [ReporteEmpleadoController::class, 'extracto'])->name('reporte.extracto');
        Route::get('/extracto/imprimir', [ReporteEmpleadoController::class, 'imprimirExtracto'])->name('reporte.extracto.imprimir');
        Route::get('/reportes/extracto-personal', [ReporteEmpleadoController::class, 'extractoPersonal'])->name('reportes.extracto.personal');
        Route::get('/reportes/extracto-personal/imprimir', [ReporteEmpleadoController::class, 'imprimirExtracto'])->name('reportes.extracto.personal.imprimir');
        Route::get('/embargos', [ReporteEmpleadoController::class, 'embargos'])->name('reporte.embargos');
        Route::get('/embargos/generar', [ReporteEmpleadoController::class, 'generarEmbargos'])->name('reporte.embargos.generar');
        Route::get('/embargos/imprimir', [ReporteEmpleadoController::class, 'imprimirEmbargos'])->name('reporte.embargos.imprimir');
        Route::get('/datos-personales', [ReporteEmpleadoController::class, 'datosPersonales'])->name('reporte.datos_personales');
    });
});

// === GERENTE/RRHH ===
Route::middleware(['auth', 'role:gerente'])->group(function () {
    // Consulta empleados (solo index y show)
    Route::get('empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::get('empleados/{empleado}', [EmpleadoController::class, 'show'])->name('empleados.show');
    // Consulta reportes y dashboards (solo lectura)
    Route::get('/nominas', [ReporteController::class, 'index'])->name('nominas.index');
    Route::prefix('reporte')->group(function () {
        Route::get('/extracto', [ReporteEmpleadoController::class, 'extracto'])->name('reporte.extracto');
        Route::get('/extracto/imprimir', [ReporteEmpleadoController::class, 'imprimirExtracto'])->name('reporte.extracto.imprimir');
        Route::get('/reportes/extracto-personal', [ReporteEmpleadoController::class, 'extractoPersonal'])->name('reportes.extracto.personal');
        Route::get('/reportes/extracto-personal/imprimir', [ReporteEmpleadoController::class, 'imprimirExtracto'])->name('reportes.extracto.personal.imprimir');
        Route::get('/embargos', [ReporteEmpleadoController::class, 'embargos'])->name('reporte.embargos');
        Route::get('/embargos/generar', [ReporteEmpleadoController::class, 'generarEmbargos'])->name('reporte.embargos.generar');
        Route::get('/embargos/imprimir', [ReporteEmpleadoController::class, 'imprimirEmbargos'])->name('reporte.embargos.imprimir');
        Route::get('/datos-personales', [ReporteEmpleadoController::class, 'datosPersonales'])->name('reporte.datos_personales');
    });
    // Nada de modificar, solo lectura.
});

// === ASISTENTE RRHH ===
Route::middleware(['auth', 'role:asistente'])->group(function () {
    // Gestión empleados (limitá lo que permite la rúbrica)
    Route::resource('empleados', EmpleadoController::class)->except(['destroy']); // Si no puede borrar, limitá los métodos
    // Gestión de ausencias, préstamos
    Route::resource('ausencias', AusenciaController::class);
    Route::resource('prestamos', PrestamoController::class);
    // Embargos y retenciones
    Route::prefix('descuentos')->group(function () {
        Route::get('/embargos/create', [EmbargoJudicialController::class, 'create'])->name('embargos.create');
        Route::post('/embargos', [EmbargoJudicialController::class, 'store'])->name('embargos.store');
        Route::get('/embargos', [EmbargoJudicialController::class, 'index'])->name('embargos.index');
        Route::resource('retenciones', RetencionSindicalController::class)->except(['show']);
        Route::get('/retenciones/create', [RetencionSindicalController::class, 'create'])->name('retenciones.create');
        Route::get('/retenciones/edit', [RetencionSindicalController::class, 'edit'])->name('retenciones.edit');
        Route::post('/retenciones', [RetencionSindicalController::class, 'store'])->name('retenciones.store');
        Route::get('/retenciones', [RetencionSindicalController::class, 'index'])->name('retenciones.index');
    });
    // Liquidaciones
    Route::prefix('liquidaciones')->group(function () {
        Route::get('individual', [LiquidacionController::class, 'individual'])->name('liquidaciones.individual');
        Route::get('total', [LiquidacionController::class, 'total'])->name('liquidaciones.total');
        Route::post('total/liquidar', [LiquidacionController::class, 'liquidarTotal'])->name('liquidaciones.liquidar-total');
        Route::get('personalizado', [LiquidacionController::class, 'personalizado'])->name('liquidaciones.personalizado');
        Route::post('personalizado/liquidar', [LiquidacionController::class, 'liquidarPersonalizado'])->name('liquidaciones.liquidarPersonalizado');
        Route::get('{empleado}', [LiquidacionController::class, 'show'])->name('liquidaciones.show');
        Route::post('{empleado}/liquidar', [LiquidacionController::class, 'liquidar'])->name('liquidaciones.liquidar');
    });
    // No accede a reportes globales ni dashboards.
});

// === EMPLEADO ===
Route::middleware(['auth', 'role:empleado'])->group(function () {
    // Su perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Su liquidación
    Route::get('/mi-liquidacion', [LiquidacionController::class, 'miLiquidacion'])->name('liquidacion.empleado');
    // Solo su propia información
});

// === Otros ===

// Ping para mantener sesión activa (puede ir en admin o general)
Route::post('/session/ping', function () {
    return response()->json(['status' => 'active']);
})->name('session.ping')->middleware('auth');

require __DIR__.'/auth.php';
