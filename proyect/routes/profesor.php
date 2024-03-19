<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\ClasesController;
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


//?rutas profesor
//! rutas clases
Route::get('clases/profesor/{idProfesor}/{indicador}', [ClasesController::class, 'clasesForCondicion'])->name('clases.profesor.index');

//!rutas de alumno
Route::get('alumnos/profesor/index', [AlumnoController::class, 'alumnosProfesor'])->name('alumnos.profesor.index');
Route::get('alumnos/profesor/{alumno}/show', [AlumnoController::class, 'fichaAlumnoForProfesor'])->name('alumnos.profesor.show');

?>