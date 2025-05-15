<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;  // Agregado para usuarios

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

    // Ruta reporte EMPLEADOS ANTES DEL RESOURCE
    Route::get('empleados/reporte', [EmpleadoController::class, 'reporte'])->name('empleados.reporte');

    // Rutas resource EMPLEADOS
    Route::resource('empleados', EmpleadoController::class);

    // Reportes generales
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');

    // Gestión de usuarios sin permisos aún, solo autenticación
    Route::resource('usuarios', UsuarioController::class);
});

Route::get('/liquidaciones', function () {
    return redirect()->route('dashboard');
})->name('liquidaciones.index')->middleware('auth');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin');

    // Opcional: crear empleado admin
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
});

Route::post('/session/ping', function () {
    return response()->json(['status' => 'active']);
})->name('session.ping')->middleware('auth');

require __DIR__.'/auth.php';
