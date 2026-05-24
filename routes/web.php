<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware("guest")->group(function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/logear', [AuthController::class, 'logear'])->name('logear');
});

Route::middleware("auth")->group(function () {
    Route::get('/home', [AuthController::class, 'home'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Rutas de Expedientes
    Route::get('/expedientes', [App\Http\Controllers\ExpedienteController::class, 'index'])->name('expedientes.index');
    Route::get('/expedientes/buscar', [App\Http\Controllers\ExpedienteController::class, 'buscar'])->name('expedientes.buscar');
    Route::get('/expedientes/{id}/consultas', [App\Http\Controllers\ExpedienteController::class, 'consultas'])->name('expedientes.consultas');
    Route::get('/expedientes/{id}/consultas/{consulta_id}', [App\Http\Controllers\ExpedienteController::class, 'verConsulta'])->name('expedientes.consultas.ver');
    Route::get('/expedientes/{id}/consultas/{consulta_id}/diagnostico', [App\Http\Controllers\ExpedienteController::class, 'diagnostico'])->name('expedientes.consultas.diagnostico');
    Route::put('/expedientes/{id}/consultas/{consulta_id}/diagnostico', [App\Http\Controllers\ExpedienteController::class, 'guardarDiagnostico'])->name('expedientes.consultas.diagnostico.guardar');
    Route::get('/expedientes/{id}/consultas/{consulta_id}/tratamiento', [App\Http\Controllers\ExpedienteController::class, 'tratamiento'])->name('expedientes.consultas.tratamiento');
    Route::put('/expedientes/{id}/consultas/{consulta_id}/tratamiento', [App\Http\Controllers\ExpedienteController::class, 'guardarTratamiento'])->name('expedientes.consultas.tratamiento.guardar');

    // Rutas de Alergias
    Route::get('/expedientes/{id}/alergias', [App\Http\Controllers\ExpedienteController::class, 'alergias'])->name('expedientes.alergias');
    Route::post('/expedientes/{id}/alergias', [App\Http\Controllers\ExpedienteController::class, 'guardarAlergia'])->name('expedientes.alergias.guardar');
    Route::delete('/expedientes/{id}/alergias/{alergia_id}', [App\Http\Controllers\ExpedienteController::class, 'eliminarAlergia'])->name('expedientes.alergias.eliminar');

    // Rutas de Patológicos
    Route::get('/expedientes/{id}/patologicos', [App\Http\Controllers\ExpedienteController::class, 'patologicos'])->name('expedientes.patologicos');
    Route::post('/expedientes/{id}/patologicos', [App\Http\Controllers\ExpedienteController::class, 'guardarPatologico'])->name('expedientes.patologicos.guardar');
    Route::delete('/expedientes/{id}/patologicos/{patologico_id}', [App\Http\Controllers\ExpedienteController::class, 'eliminarPatologico'])->name('expedientes.patologicos.eliminar');


    // Rutas del Administrador
    Route::get('/admin/home', [AuthController::class, 'adminHome'])->name('admin.home');

    // Gestión de Usuarios (CRUD)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', UserController::class)->names([
            'index'   => 'users.index',
            'create'  => 'users.create',
            'store'   => 'users.store',
            'edit'    => 'users.edit',
            'update'  => 'users.update',
            'destroy' => 'users.destroy',
        ]);
    });
});