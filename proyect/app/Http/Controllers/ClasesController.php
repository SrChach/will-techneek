<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Mexico_City');

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
use App\Notifications\ClaseAgendada;
use App\Notifications\ClaseAgendadaProfesor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ClasesController extends Controller
{

    /**
     * 
     * funcion que se encarga de enlistar las clases 
     *
     */
    public function index(): View
    {
        $clases = Clases::infoClasesAll();
        
		/*echo "<pre>";
			print_r($clases);
		echo "</pre>";*/
		
		$estados = EstadosClases::all();

        $listClases = array();
        foreach ($clases as $clase) {
            $infoAlumno = User::find($clase->idAlumno);

            $nombreAlumno = $infoAlumno->nombre . ' ' . $infoAlumno->apellidos;

            if ($clase->idProfesor != null) {
                $infoProfesor = User::find($clase->idProfesor);

                $nombreProfesor = $infoProfesor->nombre . ' ' . $infoProfesor->apellidos;
            } else {

                $nombreProfesor = null;
            }

            $objetoClase = [
                "idClase" => $clase->idClase,
                "idMateria" => $clase->idMateria,
                "fechaClase" => $clase->fechaClase,
                "horaClase" => $clase->horaClase,
                "idEstado" => $clase->idEstado,
                "estado" => $clase->estado,
                "etiqueta" => $clase->etiqueta,
                "nombreMateria" => $clase->nombreMateria,
                "idProfesor" => $clase->idProfesor,
                "idAlumno" => $clase->idAlumno,
                "pago" => $clase->pago,
                "nombreAlumno" => $nombreAlumno,
                "nombreProfesor" => $nombreProfesor
            ];

            array_push($listClases, $objetoClase);
        }

        return view('admin.clases.listar', [
            "listClases" => $listClases,
            "estados" => $estados
        ]);
    }

    public function clasesForCondicion($id = 0, $indicador = 4)
    {
        if ($id == 0) {
            $id = Auth::user()->id;
        }

        //? se establece la condicion del filtro segun el indicador
        switch ($indicador) {
            case '1':
                $condicion = 'materias.id'; //! 1 es para materias
                $infomacion = Materias::find($id);
                $encabezados = array('ID CLASE', 'ALUMNO', 'PROFESOR', 'FECHA <br> HORA', 'ESTADO <br> CLASE');
                break;
            case '2':
                $condicion = 'clases.idProfesor'; //! 2 es para profesor
                $infomacion = User::find($id);
                $encabezados = array('ID CLASE', 'MATERIA', 'ALUMNO', 'FECHA <br> HORA', 'ESTADO <br> CLASE');
                break;
            case '3':
                $condicion = 'pedidos.idAlumno'; //! 3 es para alumno
                $infomacion = User::find($id);
                $encabezados = array('ID CLASE', 'MATERIA', 'PROFESOR', 'FECHA <br> HORA', 'ESTADO <br> CLASE');
                break;
            case '4':
                $condicion = 'clases.idProfesor'; //? 4 es para la vista de clases en el perfil del profesor
                $infomacion = User::find($id);
                $encabezados = array('ID CLASE', 'MATERIA', 'ALUMNO', 'FECHA <br> HORA', 'PAGO <br> CLASE', 'ESTADO <br> CLASE', 'LINKS');
                break;
        }

        $clases = Clases::getClasesCondicion($id, $condicion);
        //dd($clases);
        $clasesList = array();
        foreach ($clases as $clase) {
            //? validar si existe profesor
            $idProfesor = $clase->idProfesor;
            if ($idProfesor === null || $idProfesor === NULL) {
                $objeto['idProfesor'] = $clase->idProfesor;
                $objeto['nombreProfesor'] = '';
            } else {
                $infoProfesor = User::find($idProfesor);
                $objeto['idProfesor'] = $clase->idProfesor;
                $objeto['nombreProfesor'] = $infoProfesor->nombre . $infoProfesor->apellidos;
            }
            $idAlumno = $clase->idAlumno;
            $infoAlumno = User::find($idAlumno);

            $objeto['idClase'] = $clase->idClase;
            $objeto['idAlumno'] = $clase->idAlumno;
            $objeto['nombreAlumno'] = $infoAlumno->nombre . ' ' . $infoAlumno->apellidos;
            $objeto['fecha'] = $clase->fecha;
            $objeto['hora'] = $clase->hora;
            $objeto['pago'] = $clase->pagoProfesor;
            $objeto['link'] = $clase->ligaMeets;
            $objeto['idEstadoClase'] = $clase->isEstadoClase;
            $objeto['nombreEstado'] = $clase->nombreEstado;
            $objeto['etiquetaEstados'] = $clase->etiquetaEstados;
            $objeto['idMateria'] = $clase->idMateria;
            $objeto['nombreMateria'] = $clase->nombreMateria;

            array_push($clasesList, $objeto);
        }

        $estados = EstadosClases::all();

        return view('admin.clases.condicion', [
            "indicador" => $indicador,
            "clasesList" => $clasesList,
            "informacion" => $infomacion,
            "encabezados" => $encabezados,
            "estados" => $estados
        ]);
    }

    //? metodos del profesor

    /**
     * 
     * funcion que se encarga de enlistar las clases para el profesor
     *
     */
    public function clasesProfesor(): View
    {
        $estados = EstadosClases::all();
        return view('profesores.clases.listar', [
            "estados" => $estados
        ]);
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

        $numeroTotal = $numeroClases - 1;
        for ($i = 0; $i <= $numeroTotal; $i++) {
            $clase = new Clases();
            $clase->idPedido = $idPedido;
            $clase->idEstados = 1;
            $clase->save();
        }
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

    /**
     * programacion de la claase
     * 
     */
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
