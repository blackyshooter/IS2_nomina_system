<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\AsignarRolController;


// Rutas de administración
Route::prefix('admin')->middleware('auth')->group(function () {
    // Rutas de Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Rutas de Roles
    Route::resource('roles', RolController::class);

    // Rutas de Asignación de Roles
    Route::get('asignar-roles', [AsignarRolController::class, 'index'])->name('asignar_roles.index');
    Route::post('asignar-roles', [AsignarRolController::class, 'store'])->name('asignar_roles.store');
    
    // Rutas de Empleados
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{id}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');

    // Rutas de Liquidaciones
    Route::resource('liquidaciones', LiquidacionController::class);

    // Rutas de Reportes
    Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
});

// Ruta raíz
Route::get('/', function () {
    return view('welcome');
});

// Ruta para el Dashboard (solo para usuarios autenticados)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Rutas de perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Ruta de ping para mantener la sesión activa
Route::post('/session/ping', function () {
    return response()->json(['status' => 'active']);
})->name('session.ping')->middleware('auth');

// Rutas de autenticación
require __DIR__.'/auth.php';
