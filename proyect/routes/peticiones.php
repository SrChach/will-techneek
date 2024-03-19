<?php

use App\Http\Controllers\Api\MateriaController;
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

    //! Api Materias
    Route::get('peticion/materia/{idMateria}', [MateriaController::class, 'getMateria']);

});

?>