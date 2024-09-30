<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Mexico_City');

use App\Application\Clases\Clase;
use App\Application\Clases\Materia;
use App\Application\Profesor;
use App\Exceptions\PedidosException;
use App\Exceptions\ProfesorException;
use App\Exceptions\UserException;
use App\Exceptions\ValidationException;
use App\Mail\ClaseProgramadaAlumnoMailer;
use App\Mail\ClaseProgramadaProfesorMailer;
use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\EstadosPagos;
use App\Models\Materias;
use App\Models\Pedidos;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\OneSignalAlertController;
use App\Models\Roles;
use App\Models\UsuariosMaterias;
use App\Notifications\ClaseAgendada;
use App\Notifications\ClaseAgendadaProfesor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ClasesApiController extends Controller
{

    public function list(Request $request) {
        $user = $request->user();

        if (!$user) {
            throw UserException::notFound();
        }

        if($user->idRol != Roles::ALUMNO) {
            throw UserException::invalidRole('ALUMNO');
        }

        $pedidosQuery = Pedidos::select('id')->where('idAlumno', $user->id);
        if ($request->status_pago) {
            // TODO add validation for EstadosPagos
            $pedidosQuery = $pedidosQuery->where('idEstadoPago', $request->status_pago);
        }

        $pedidos = $pedidosQuery->get();
        if (!$pedidos) {
            throw PedidosException::sinPedidos();
        }

        $pedidos_id = $pedidos->map(function ($time) {
            return $time['id'];
        });

        $clases = Clases::whereIn('idPedido', $pedidos_id)
            ->with('profesor')
            ->with('pedido')
            ->get();

        return response()->json($clases);
    }

    public function asignarProfesor(Request $request, $idClase) {
        $clase = Clases::where('id', $idClase)->with('pedido')->first();
        
        if (!$request->idProfesor) {
            throw ValidationException::requiredParameter('idProfesor');
        }

        $is_assigned_materia = UsuariosMaterias::where('idUsuario', $request->idProfesor)
            ->where('idMateria', $clase->pedido['idMateria'])
            ->where('is_authority', true)
            ->first();

        if (!$is_assigned_materia) {
            throw ProfesorException::incorrectAssignment();
        }

        $clase->idProfesor = $request->idProfesor;
        $clase->save();

        return response()->json($clase, 201);
    }

    //? metodos del alumno

    /**
     * 
     * funcion que se encarga de enlistar las clases para el alumno
     *
     */
    public function clasesAlumnos(): View
    {
        $idAlumno = Auth::user()->id;
        $condicion = 'pedidos.idAlumno';

        $infoClasesProgramadas = Clases::getLastAllClasesForUsuario($idAlumno, 2, $condicion);
        $infoClasesImpartidas = Clases::getLastAllClasesForUsuario($idAlumno, 4, $condicion);
        $infoClasesPorProgramar = Clases::getLastAllClasesPorProgramar($idAlumno, 1, $condicion);
		$estados = EstadosClases::all();

        return view('alumnos.clases.listar', [
            "estados" => $estados,
            "infoClasesProgramadas" => $infoClasesProgramadas,
            "infoClasesImpartidas" => $infoClasesImpartidas,
            "infoClasesPorProgramar" => $infoClasesPorProgramar
        ]);
    }

    /**
     * 
     * funcion que se encarga de crear las clases de un pedido
     *
     */
    public function fichaAlumno($idClase)
    {
        $clase = Clases::getFichaClase($idClase);


        return view('alumnos.clases.ficha', [
            "clase" => $clase
        ]);
    }

    /**
     * 
     * funcion que se encarga de crear las clases de un pedido
     *
     */
    public function crearClases($numeroClases, $idPedido)
    {
        Clase::createBatch($numeroClases, $idPedido);
    }

    /**
     * 
     * funcion que se encarga de asignar horarios
     *
     */
    public function generarHorarios($idClase)
    {

        $infoClase = Clases::find($idClase);
        $idPedido = $infoClase->idPedido;
        $infoPedido = Pedidos::find($idPedido);
        $idMateria = $infoPedido->idMateria;

        return view('alumnos.clases.programacion', [
            "idMateria" => $idMateria,
            "idClase" => $idClase
        ]);
    }

    public function programarClase(Request $request, $idClase)
    {

        $fecha = $request->fecha;
        $hora_inicio = $request->horarios;
        $idProfesor = $request->profesores;
        $linkConference = $request->linkConference;
        $horaArray = explode('-', $hora_inicio);

        $clase = Clases::find($idClase);
        $clase->idEstados = 2;
        $clase->idProfesor = $idProfesor;
        $clase->fecha = $fecha;
        $clase->hora = $hora_inicio;
        $clase->meeets = $linkConference;
        $clase->save();

        $pedido = Pedidos::find($clase->idPedido);
        $idAlumno = $pedido->idAlumno;

        $infoProfesor = User::find($idProfesor);
        $infoMateria = Materias::find($pedido->idMateria);
        $infoAlumno = User::find($idAlumno);
        $infoFecha = app(FechaController::class)->formatearFecha($fecha, $hora_inicio);
        $diaSemana = app(FechaController::class)->diaSemana($infoFecha['diaSemana']);
        $infoMes = app(FechaController::class)->mesNombre($infoFecha['numeroMes']);

        Mail::to(Auth::user()->email)->send(new ClaseProgramadaAlumnoMailer($idClase, $idAlumno));
        Mail::to($infoProfesor->email)->send(new ClaseProgramadaProfesorMailer($idClase, $infoProfesor->id));
        
        $messageProfesor = "Se ha agendado una nueva clase de " . $infoMateria->nombre . " el día 
            " . $diaSemana['nombreDiaSemana'] . " " . $infoFecha['diaMes'] . " " . $infoMes['nombreMes'] . " a las " . date('h:s a', strtotime($horaArray[0]));
        $messageAlumno = "Se ha agendado tu clase " . $infoMateria->nombre . " el " .date('d-m-Y', strtotime($fecha));
        $messageAdmin = "Nueva clase de " . $infoMateria->nombre . " registrada por " . $infoAlumno->nombre .
            " con el prof. " . $infoProfesor->nombre .  "  " . date('d-m-Y', strtotime($fecha)) . " a las "  . date('h:s a', strtotime($horaArray[0]));  

        app(OneSignalAlertController::class)->getDevicesForUser($messageAdmin, 1); 
        app(OneSignalAlertController::class)->getDevicesForUser($messageAlumno, Auth::user()->id);
        app(OneSignalAlertController::class)->getDevicesForUser($messageProfesor, $idProfesor); 

        SELF::generarNotificacionLive($idAlumno, $idProfesor, $idClase, $messageProfesor); 

        $respuesta['mensaje'] = "Clase programada con éxito.";
        $respuesta['idClase'] = $idClase;
        $respuesta['idProfesor'] = $idProfesor;
        $respuesta['idAlumno'] = $idAlumno;

        return response()->json($respuesta);
    }

    
    /**
     * metodo para mandar notificacion de campanita
     */
    public function generarNotificacionLive($idAlumno, $idProfesor, $idClase, $mensajeProfesor)  
    {
        $usuarioAlumno = User::where('id', $idAlumno)->first();
        $usuarioProfesor = User::where('id', $idProfesor)->first();

        Notification::send($usuarioAlumno, new ClaseAgendada($idClase));
        Notification::send($usuarioProfesor, new ClaseAgendadaProfesor($idClase, $mensajeProfesor));
    }

    /**
     * metodo para optener la informacion de una clase
     */
    public function getInfoForProgramacion(Request $request)
    {
        
        $infoProfesor = User::find($request->profesores);
        $infoMateria = Materias::find($request->idMateria);
        $correoProfesor = $infoProfesor->email;
        $nombreMateria = $infoMateria->nombre;
        $seccionHorarios = explode('-', $request->horarios);
        $fechaIncio = $request->fecha . ' ' . $seccionHorarios[0];
        $fechaFinal = $request->fecha . ' ' . $seccionHorarios[1]; 

        $formatoFechaInicio = SELF::getDataTimeFecha($fechaIncio);
        $formatoFechaFin = SELF::getDataTimeFecha($fechaFinal);

        $infoFinal = array(
            "correoProfesor" => $correoProfesor,
            "nombreMateria" => $nombreMateria,
            "idClase" => $request->idClase,
            "formatoFechaInicio" => $formatoFechaInicio, 
            "formatoFechaFin" => $formatoFechaFin,
            "fechaIncio" => $fechaIncio,
            "fechaFinal" => $fechaFinal,
        ); 

        return response()->json($infoFinal);  
    }

    public function getDataTimeFecha($fechaCompleta)
    {
        $date = new DateTime($fechaCompleta, new DateTimeZone('America/Mexico_City'));
        return $date->format(DATE_RFC3339);
    }

    public function getDataTimeFechaDos($fechaCompleta)
    {

        $timezone = new \DateTimeZone('America/Mexico_City');
        $needed_time = new \DateTime($fechaCompleta, $timezone);

        //echo $needed_time->getTimezone()->getName() . "\n";
        //return $needed_time->format(DATE_ISO8601_EXPANDED);

        return date(DATE_RFC3339, strtotime($fechaCompleta));
    }

    public function envioTest()  
    {
        $message = "Hola esto es una alerta";
        app(OneSignalAlertController::class)->getDevicesForUser($message, Auth::user()->id);
    }

}
