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