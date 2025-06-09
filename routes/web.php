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
use App\Http\Controllers\NominaController;


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
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
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
});

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
