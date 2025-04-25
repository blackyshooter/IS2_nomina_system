<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AuthController;




/*Route::get('/admin', function () {
    return view('admin');
})->name('admin')->middleware(['auth', 'solo_admin']);*/


// PROTEGER RUTAS
Route::middleware('auth')->group(function () {
    // Rutas de autenticación
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/admin', function () {
        return view('admin');
    })->name('admin')->middleware(['auth', 'solo_admin']);
    
    Route::get('/empleados', [EmpleadoController::class, 'index'])->name('empleados.index');    
    Route::get('/empleados/create', [EmpleadoController::class, 'create'])->name('empleados.create');
    Route::post('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');
    Route::get('/empleados/{id}/edit', [EmpleadoController::class, 'edit'])->name('empleados.edit');
    Route::put('/empleados/{id}', [EmpleadoController::class, 'update'])->name('empleados.update');
    Route::delete('/empleados/{id}', [EmpleadoController::class, 'destroy'])->name('empleados.destroy');

    //asignacion de rol
    Route::get('/empleados/{empleado}/asignar-rol', [EmpleadoController::class, 'asignarRolForm'])->name('empleados.asignarRolForm');
    Route::post('/empleados/{empleado}/asignar-rol', [EmpleadoController::class, 'asignarRolStore'])->name('empleados.asignarRolStore');

});

