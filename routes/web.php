<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\AuthController;

// Rutas públicas (Login)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Rutas protegidas (Solo entra si has iniciado sesión)
Route::middleware('auth')->group(function () {
    
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // El Calendario y las Reservas
    Route::get('/', [ReservaController::class, 'index'])->name('reservas.index');
    Route::post('/reservas/manual', [ReservaController::class, 'storeManual'])->name('reservas.store');
    
    // NUEVAS RUTAS CRUD: Editar y Eliminar
    Route::put('/reservas/{reserva}', [ReservaController::class, 'update'])->name('reservas.update');
    Route::delete('/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('reservas.destroy');

    // Exportar PDF
    Route::get('/reservas/pdf', [ReservaController::class, 'exportarPDF'])->name('reservas.pdf');
    
});