<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\MateriasApiController;
use App\Http\Controllers\PedidosApiController;
use App\Http\Controllers\PerfilApiController;
use App\Http\Controllers\ProfesorApiController;
use App\Http\Controllers\TemasApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [LoginRegisterController::class, 'register']);

Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/login', 'login');
});

Route::middleware([])->group(function() {
    Route::get('materias', [MateriasApiController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('materias')->group(function () {
        Route::get('full', [MateriasApiController::class, 'fullList']);
        Route::post('', [MateriasApiController::class, 'store']);

        Route::get('{idMaterias}/temas', [TemasApiController::class, 'list']);
        Route::post('{idMaterias}/temas', [TemasApiController::class, 'addBatch']);
    });

    Route::prefix('pedidos')->group(function () {
        Route::get('all', [PedidosApiController::class, 'index']);
        Route::get('', [PedidosApiController::class, 'get']);

        Route::post('', [PedidosApiController::class, 'store']);
        Route::get('folio/{folio}', [PedidosApiController::class, 'show']);
        Route::get('folio/{folio}/detalle', [PedidosApiController::class, 'resumenPedido']);
        Route::put('folio/{folio}', [PedidosApiController::class, 'pedidoPagado']);
    });

    Route::prefix('profesor')->group(function () {
        Route::get('demo', [ProfesorApiController::class, 'showMateriasUsuarios']);
    });

    Route::get('user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('perfil')->group(function () {
        Route::put('password', [PerfilApiController::class, 'updatePassword']);
        Route::post('materia', [PerfilApiController::class, 'addMateria']);
        Route::delete('materia', [PerfilApiController::class, 'deleteMateria']);
        Route::post('horario', [PerfilApiController::class, 'addHorario']);
        Route::delete('horario', [PerfilApiController::class, 'deleteHorario']);
    });

    Route::get('clases/all', [ClasesController::class, 'clasesIndex']);

    Route::get('logout', [LoginRegisterController::class, 'logout']);
});

