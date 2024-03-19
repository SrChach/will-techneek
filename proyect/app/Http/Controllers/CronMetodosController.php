<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Mexico_City');

use App\Models\Clases;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CronMetodosController extends Controller
{
    
    public function clasesProgramadasDelDia()  
    {
        $fechaInicio = date('Y-m-d') . " 00:00:00";
        $fechaFin = date('Y-m-d') . "23:59:59";
        
        $alumnos = User::where('idRol', 3)->get();

        foreach ($alumnos as $alumno) {
            $clasesProgramadas = Clases::select('clases.id AS idClase')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->where('pedidos.idAlumno', $alumno->id)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])->get();

            $cantidadClases = count($clasesProgramadas);

            if($cantidadClases > 0){
                $mensaje = "No lo olvides, hoy tienes " . $cantidadClases . " clases programadas. Revisa tu horario";
        
                app(OneSignalAlertController::class)->getDevicesForUser($mensaje, $alumno->id); 
            }
        }
    }

    public function comienzoDeClase()  
    {
        $d = time();
        $miHora= date("H:i:s", strtotime("+1 Hours", $d));

        $clases = Clases::select('materias.nombre AS nombreMateria', 'pedidos.idAlumno AS idAlumno', 'clases.idProfesor AS idProfesor')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('clases.hora', $miHora)
            ->get();

        foreach ($clases as $clase) {
            $messageAlumno = "Tu clase de " . $clase->nombreMateria . " comenzará en una hora. ¡Prepárate!";
            $mensajeProfesor = "Tu clase de " . $clase->nombreMateria . " con [Nombre de alumno] comenzará en una hora. ¡Prepárate!";

            app(OneSignalAlertController::class)->getDevicesForUser($messageAlumno, $clase->idAlumno); 
            app(OneSignalAlertController::class)->getDevicesForUser($mensajeProfesor, $clase->idProfesor); 

        }
    }

    public function clasesProgramadasDelDiaProfesor()  
    {
        $fechaInicio = date('Y-m-d') . " 00:00:00";
        $fechaFin = date('Y-m-d') . "23:59:59";
        
        $profesores = User::where('idRol', 3)->get();

        foreach ($profesores as $profesor) {
            $clasesProgramadas = Clases::select('clases.id AS idClase')
            ->where('clases.idProfesor', $profesor->id)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])->get();

            $cantidadClases = count($clasesProgramadas);

            if($cantidadClases > 0){
                $mensaje = "No olvides que hoy tienes " . $cantidadClases . " clases programadas. Revisa tu horario en la plataforma";
        
               
            }
        }
    }

    public function testCron()
    {
        $mensaje = "mensaje de prueba de cron";

        app(OneSignalAlertController::class)->getDevicesForUser($mensaje, 1); 
        app(OneSignalAlertController::class)->getDevicesForUser($mensaje, 14); 
    }

}
