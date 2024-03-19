<?php

use App\Http\Controllers\BitacorasController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\HorariosController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\TemasController;
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

    //?alumnos
    //! clases
    Route::get('clases/alumno/index', [ClasesController::class, 'clasesAlumnos'])->name('clases.alumno.index');
    Route::get('clases/alumno/{idClase}/asignar', [ClasesController::class, 'generarHorarios'])->name('clases.alumno.asignar');
    Route::post('clases/alumno/{idClase}/programar', [ClasesController::class, 'programarClase'])->name('clases.alumno.programar');
    Route::post('clases/alumnno/informacion', [ClasesController::class, 'getInfoForProgramacion'])->name('clases.info');

    //!2023-11-26T09:00:00-07:00
    //!2023-11-26T17:00:00-07:00

    //! materias y temas
    Route::get('materia/ficha/{idMateria}', [MateriasController::class, 'getFichaMateriaAlumno'])->name('materia.alumno.ficha');
    Route::get('tema/lista/{idMateria}', [TemasController::class, 'listar'])->name('tema.listar');

    //! pedidos
    Route::get('pedidos', [PedidosController::class, 'index'])->name('pedidos.index');
    Route::post('pedidos', [PedidosController::class, 'store'])->name('pedidos.store');
    Route::get('pedidos/resumen/{folio}/', [PedidosController::class, 'resumenPedido'])->name('pedido.resumen');
    Route::post('pedidos/pago/{pedido}/aceptado', [PedidosController::class, 'updatePedido'])->name('pedidos.update.aceptado');
    Route::get('pedidos/create', [PedidosController::class, 'create'])->name('pedidos.create');
    Route::get('pedidos/{pedido}/show', [PedidosController::class, 'show'])->name('pedidos.show');


	Route::get('pedidos/profesoresMateria/{id}', [PedidosController::class, 'profesoresMateria'])->name('pedidos.profesoresMateria'); 
	
	
    //! horarios
    Route::get('horarios/materia/{idMateria}', [HorariosController::class, 'obtenerHorariosForClase'])->name('horarios.clase');
    Route::post('horarios/dia', [HorariosController::class, 'obtenerHorariosPorFecha'])->name('horarios.dia');

    //! profesores
    Route::get('profesor/ficha/{idProfesor}', [ProfesorController::class, 'getFichaProfesorAlumno'])->name('profesor.alumno.ficha');
    Route::post('profesores/buscar', [ProfesorController::class, 'buscarProfesores'])->name('profesores.buscar.horario'); 

    //! calendario 
    Route::get('calendario/alumno/{idAlumno}/{indicador}', [CalendarController::class, 'getClasesForUsuario'])->name('calendario.alumno.general');
    Route::get('calendario/get/materia/{idMateria}', [CalendarController::class, 'getHorariosDispForMateria'])->name('calendario.alumno.formateria');
});
