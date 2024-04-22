<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register/store', [RegisteredUserController::class, 'store'])->name('register.store');
	
	Route::get('register/verificarCorreo', [RegisteredUserController::class, 'verificarCorreo'])->name('register.verificarCorreo');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::view('forgot-password', 'auth.forgot-password')->name('forgotPassword.get');
    Route::post('forgot-password', [AuthenticatedSessionController::class, 'forgotPassword'])->name('forgotPassword.post');

    Route::get('recuperacion/password/{id}/{token}', [AuthenticatedSessionController::class, 'recuperar'])->name('recuperar');
    Route::post('cambio/password/', [AuthenticatedSessionController::class, 'cambiarContraseña'])->name('cambioContraseña');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
