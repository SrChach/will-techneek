<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\MateriasController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\BitacoraAdministradorController;
use App\Http\Controllers\BitacoraAlumnoController;
use App\Http\Controllers\BitacoraProfesorController;
use App\Http\Controllers\BitacorasController;
use App\Http\Controllers\ClasesController;
use App\Http\Controllers\CronMetodosController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\OneSignalAlertController;
use App\Http\Controllers\PedidosController;
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

Route::get('/google-auth/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/google-auth/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

Route::get('cronHora', [DashboardController::class, 'cronHora'])->name('cronHora');
Route::get('cambio/clase/impartida', [DashboardController::class, 'cambioEstadoImpartida'])->name('cron.clase.impartida');

Route::middleware('auth')->group(function () {

    //* dashboard - rutas generales
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    //* back mp
    Route::get('pedidos/feedback/{folio}', [PedidosController::class, 'feedback']);

    //* buscador
    Route::post('/buscar/alumno', [AlumnoController::class, 'buscarAlumno'])->name('search.alumno');
    Route::post('/ordenar/alumno', [AlumnoController::class, 'ordenar'])->name('ordenar.alumno');
	
	
	
	//* buscador
    Route::post('/buscar/materia', [MateriasController::class, 'buscarMateria'])->name('search.materia');
    Route::post('/ordenar/materia', [MateriasController::class, 'ordenar'])->name('ordenar.materia'); 
	
	//* buscador
    Route::post('/buscar/profesor', [ProfesorController::class, 'buscarProfesor'])->name('search.profesor');
    Route::post('/ordenar/profesor', [ProfesorController::class, 'ordenar'])->name('ordenar.profesor'); 
	

    //*fichas - rutas generales
    Route::get('clases/ficha/{idClase}', [BitacorasController::class, 'show'])->name('ficha.show');
    Route::get('clases/create/{idClase}/{idProfesor}/{idAlumno}', [BitacorasController::class, 'create'])->name('ficha.create');
    Route::get('clases/ficha/profesor/{idClase}', [BitacoraProfesorController::class, 'show'])->name('bitacora.profesor');
    Route::post('clases/ficha/profesor/obs/{idClase}', [BitacoraProfesorController::class, 'enviarObservaciones'])->name('bitacora.profesor.obs');
    Route::post('clases/ficha/profesor/obsfin/{idClase}', [BitacoraProfesorController::class, 'enviarObservacionesFinales'])->name('bitacora.profesor.obsfinal');
    Route::post('clases/ficha/subir/material/{idClase}/{condicion}', [BitacoraProfesorController::class, 'subirMateriales'])->name('bitacora.subir.archivo');
    Route::get('clases/ficha/eliminar/material/{idClase}', [BitacoraProfesorController::class, 'deleteMateriales'])->name('bitacora.eliminar.archivo');
    Route::get('clases/ficha/alumno/{idClase}', [BitacoraAlumnoController::class, 'show'])->name('bitacora.alumno');
    Route::get('clases/ficha/admin/{idClase}', [BitacoraAdministradorController::class, 'show'])->name('bitacora.administrador');
    Route::post('clases/ficha/pago/profesor/{idClase}', [BitacoraAdministradorController::class, 'pagoProfesor'])->name('bitacora.pago.profesor');
    //envio de bitacoras
    Route::post('calificar/sujeto/{idClase}/{condicion}', [BitacorasController::class, 'store'])->name('ficha.store');
	
	Route::get('cronAviso', [DashboardController::class, 'cronAviso'])->name('cronAviso');

    

    Route::post('onesignal/save/data', [OneSignalAlertController::class, 'alertOneSiganlFirst']);
    Route::get('onesignal/push/test', [ClasesController::class, 'envioTest']);
	
	Route::get('Notificaciones', [DashboardController::class, 'Notificaciones'])->name('Notificaciones');


	
});

//!enlaces para el cron
Route::get('notificacion/clases/programadas/alumno', [CronMetodosController::class, 'clasesProgramadasDelDia']);
Route::get('notificacion/hora/antes', [CronMetodosController::class, 'comienzoDeClase']);
Route::get('notificacion/clases/programadas/profesor', [CronMetodosController::class, 'clasesProgramadasDelDiaProfesor']);
Route::get('notificacion/test/cron', [CronMetodosController::class, 'testCron']);

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/alumno.php';
require __DIR__ . '/profesor.php';
require __DIR__ . '/perfil.php';
require __DIR__ . '/peticiones.php';
require __DIR__ . '/test.php';