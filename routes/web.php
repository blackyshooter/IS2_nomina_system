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
use App\Http\Controllers\ConceptoSalarialController;

//use App\Http\Controllers\NominaController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reporte empleados antes del resource
    Route::get('empleados/reporte', [EmpleadoController::class, 'reporte'])->name('empleados.reporte');

    // Rutas resource empleados (todas las rutas: index, create, store, show, edit, update, destroy)
    Route::resource('empleados', EmpleadoController::class);

    // Reportes generales
    //Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/nominas', [ReporteController::class, 'index'])->name('nominas.index');
    Route::resource('ausencias', AusenciaController::class);
    Route::resource('prestamos', PrestamoController::class);

    // Gestión usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Rutas para liquidaciones
    Route::prefix('liquidaciones')->group(function () {
        Route::get('individual', [LiquidacionController::class, 'individual'])->name('liquidaciones.individual');
        Route::get('total', [LiquidacionController::class, 'total'])->name('liquidaciones.total');
        Route::post('total/liquidar', [LiquidacionController::class, 'liquidarTotal'])->name('liquidaciones.liquidar-total');
        Route::get('personalizado', [LiquidacionController::class, 'personalizado'])->name('liquidaciones.personalizado');
        Route::post('personalizado/liquidar', [LiquidacionController::class, 'liquidarPersonalizado'])->name('liquidaciones.liquidarPersonalizado');
        Route::get('{empleado}', [LiquidacionController::class, 'show'])->name('liquidaciones.show');
        Route::post('{empleado}/liquidar', [LiquidacionController::class, 'liquidar'])->name('liquidaciones.liquidar');
    });

    //RUTA DE EMBARGOS Y RETENCIONES
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
});

// Ruta para reportes
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

//Ruta conceptos salariales
Route::resource('conceptos-salariales', ConceptoSalarialController::class)->only([
    'create', 'store'
]);

// Ruta adicional para redirigir a dashboard si se accede directamente a /liquidaciones
Route::get('/liquidaciones', function () {
    return redirect()->route('dashboard');
})->name('liquidaciones.index')->middleware('auth');

// Rutas solo para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');
});

// Ping para mantener sesión activa
Route::post('/session/ping', function () {
    return response()->json(['status' => 'active']);
})->name('session.ping')->middleware('auth');

require __DIR__.'/auth.php';
