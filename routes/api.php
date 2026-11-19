<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\PeticioneController;
use Illuminate\Support\Facades\Route;

// Todas estas rutas llevan el prefijo /api  (ej: http://127.0.0.1:8000/api/peticiones)

// ---------- Públicas ----------
Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::get('categorias', [CategoriaController::class, 'index'])->name('api.categorias.index');

Route::get('peticiones', [PeticioneController::class, 'index'])->name('api.peticiones.index');
Route::get('peticiones/{id}', [PeticioneController::class, 'show'])->name('api.peticiones.show');

// ---------- Protegidas (Authorization: Bearer <token>) ----------
Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'me'])->name('api.user');
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');

    Route::controller(PeticioneController::class)->group(function () {
        Route::get('mispeticiones', 'listMine')->name('api.peticiones.mine');
        Route::get('peticionesfirmadas', 'peticionesFirmadas')->name('api.peticiones.firmadas');

        Route::post('peticiones', 'store')->name('api.peticiones.store');
        Route::put('peticiones/{id}', 'update')->name('api.peticiones.update');
        Route::delete('peticiones/{id}', 'delete')->name('api.peticiones.delete');
        Route::post('peticiones/firmar/{id}', 'firmar')->name('api.peticiones.firmar');
    });
});
