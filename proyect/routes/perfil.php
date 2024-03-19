<?php

use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {

    //!Rutas de perfil
    Route::get('perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::post('perfil/datos', [PerfilController::class, 'updateDatos'])->name('perfil.datos');
    Route::post('perfil/password', [PerfilController::class, 'updatePassword'])->name('perfil.password');
    Route::post('perfil/materia', [PerfilController::class, 'addMateria'])->name('perfil.materia');
    Route::post('perfil/materia/delete', [PerfilController::class, 'deleteMateria'])->name('perfil.materia.delete');
    Route::post('perfil/horario', [PerfilController::class, 'addHorario'])->name('perfil.horario');
    Route::post('perfil/avatar', [PerfilController::class, 'updateAvatar'])->name('perfil.avatar');
    Route::get('prefil/horario/delete/{horario}', [PerfilController::class, 'deleteHorrio'])->name('perfil.horario.delete');

});

?>