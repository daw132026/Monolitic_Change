<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\PeticioneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'home'])->name('home');

// Breeze redirige a "dashboard" en algunos sitios: lo mandamos a home.
Route::redirect('/dashboard', '/')->name('dashboard');

// ---------- Peticiones públicas (sin login) ----------
Route::controller(PeticioneController::class)->group(function () {
    Route::get('peticiones/index', 'index')->name('peticiones.index');
    Route::get('peticiones/{id}', 'show')->whereNumber('id')->name('peticiones.show');
});

// ---------- Acciones que necesitan estar logueado ----------
Route::middleware('auth')->group(function () {
    Route::get('/users/firmas', [UserController::class, 'peticionesFirmadas']);

    Route::controller(PeticioneController::class)->group(function () {
        Route::get('mispeticiones', 'listMine')->name('peticiones.mine');
        Route::get('peticionesfirmadas', 'peticionesFirmadas')->name('peticiones.peticionesfirmadas');
        Route::get('peticion/add', 'create')->name('peticiones.create');
        Route::post('peticion', 'store')->name('peticiones.store');
        Route::delete('peticiones/{id}', 'delete')->name('peticiones.delete');
        Route::put('peticiones/{id}', 'update')->name('peticiones.update');
        Route::post('peticiones/firmar/{id}', 'firmar')->name('peticiones.firmar');
        Route::get('peticiones/edit/{id}', 'edit')->name('peticiones.edit');
    });

    // Perfil (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
