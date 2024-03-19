<?php 

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\FiltroController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\DashboardController;
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
  //!Rutas del adminitrador
    //* materias
    Route::get('materia', [MateriasController::class, 'index'])->name('materia.index');
    Route::post('materia', [MateriasController::class, 'store'])->name('materia.store');
    Route::get('materia/create', [MateriasController::class, 'create'])->name('materia.create');
    Route::get('materia/{materia}/show', [MateriasController::class, 'show'])->name('materia.show');
    Route::get('materia/{materia}/edit', [MateriasController::class, 'edit'])->name('materia.edit');
    Route::put('materia/{materia}/update', [MateriasController::class, 'update'])->name('materia.update');

    //* clases
    Route::get('clase', [ClasesController::class, 'index'])->name('clase.index');
    Route::post('clase/filtro', [ClasesController::class, ''])->name('clase.filtro');
    Route::get('clases/admin/seccion/{id}/{indicador}', [ClasesController::class, 'clasesForCondicion'])->name('admin.clases.materia');

    //* alumnos 
    Route::get('alumno', [AlumnoController::class, 'index'])->name('alumno.index');
    Route::get('alumno/{alumno}/show', [AlumnoController::class, 'show'])->name('alumno.show');
    Route::get('alumno/admin/seccion/{id}/{indicdor}', [AlumnoController::class, 'alumnosForCondicion'])->name('admin.alumnos.condicion');
    Route::get('clases/last/days', [DashboardController::class, 'getClasesForLastEightDays'])->name('admin.clases.last.day');

    //* profesores
    Route::get('profesor', [ProfesorController::class, 'index'])->name('profesor.index');
    Route::post('profesor', [ProfesorController::class, 'store'])->name('profesor.store');
    Route::get('profesor/{profesor}/show', [ProfesorController::class, 'show'])->name('profesor.show');

    //* usuarios
    Route::get('usuario/{usuario}/suspender', [UsuariosController::class, 'suspender'])->name('usuario.suspender');
    Route::get('usuario/{usuario}/activar', [UsuariosController::class, 'activar'])->name('usuario.activar');

    //*filtro
    Route::post('filtro/clases/{condicion}/', [FiltroController::class, 'filtro'])->name('filtro');
    Route::post('filtro/clases/{idSujeto}/{condicion}', [FiltroController::class, 'filtroForCondicion'])->name('filtro.condicion');

    //* Calendario 
    Route::get('calendario/admin', [CalendarController::class, 'getClases'])->name('calendario.general'); 
    Route::get('calendario/admin/{idClase}', [CalendarController::class, 'getInfoClase'])->name('calendario.clase.info');
});

?>