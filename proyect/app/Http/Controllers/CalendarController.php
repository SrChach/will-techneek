<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use App\Models\Horarios;
use App\Models\User;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function getClases()
    {

        $infoClases = Clases::getClasesForCalendar();

        $listClases = array();
        foreach ($infoClases as $clase) {
			$Hora=substr($clase->horaClase, 0,5);
            $objeto = array(
                "id" => $clase->idClase, //? id de la Clase
                "title" => $Hora." \n ".$clase->nombreMateria,
                "estado" => $clase->estado,
                "color" => $clase->colorEstado,
                "start" => $clase->fechaClase,
                "end" => $clase->horaClase
            );

            array_push($listClases, $objeto);
        }

        return response()->json($listClases);
    }

    public function getClasesForUsuario($id, $indicador)
    {

        switch ($indicador) {
            case '1': //!profesor
                $condicion = 'clases.idProfesor';
                break;

            case '2': //!alumno
                $condicion = 'pedidos.idAlumno';
                break;

            case '3': //!materia
                $condicion = 'pedidos.idMateria';
                break;
        }

        $clases = User::getClasesCalendarForUsuario($id, $condicion);

        $listClases = array();
        foreach ($clases as $clase) {
            $objeto = array(
                "id" => $clase->idClase, //? id de la Clase
                "title" => $clase->nombreMateria,
                "color" => $clase->colorEstado,
                "start" => $clase->fechaClase.'T'.$clase->horaClase,
                "allDay" => false,
                //"end" => $clase->fechaClase
            );

            array_push($listClases, $objeto);
        }

        return response()->json($listClases);
    }

    /**
     * optiene la informacion de una clase
     */
    public function getInfoClase($id)
    {
        $clase = Clases::getInfoClaseForCalendar($id);
        $formatFecha = app(FechaController::class)->formatearFecha($clase->fechaClase, $clase->horaClase);
        $mesInfo = app(FechaController::class)->mesNombre($formatFecha['numeroMes'],);
        $infoProfesor = User::find($clase->idProfesor);
        $infoAlumno = User::find($clase->idAlumno);

        $objetoClase = array(
            "idClase" => $clase->idClase,
            "idProfesor" => $clase->idProfesor,
            "idAlumno" => $clase->idAlumno,
            "idMateria" => $clase->idMateria,
            "diaMes" => $formatFecha['diaMes'],
            "diaSemana" => $formatFecha['diaSemana'],
            "numeroMes" => $formatFecha['numeroMes'], 
            "nombreMes" => $mesInfo['nombreMes'],
            "mesAbrtNombre" => $mesInfo['mesAbrtNombre'],
            "horaAtrr" => $formatFecha['horaAtrr'],
            "horaCeros" => $formatFecha['horaCeros'],
            "year" => $formatFecha['year'], 
            "nombreMateria" => $clase->nombreMateria,
            "nombreProfesor" => $infoProfesor->nombre,
            "apellidosProfesor" => $infoProfesor->apellidos,
            "avatarProfesor" => $infoProfesor->foto,
            "nombreAlumno" => $infoAlumno->nombre,
            "apellidosAlumno" => $infoAlumno->apellidos,
            "avatarAlumno" => $infoAlumno->foto,
            "icono" => $clase->iconoMateria,
            "estado" => $clase->estado,
            "color" => $clase->colorEstado,
            "etiqueta" => $clase->etiqueta,
            "start" => $clase->fechaClase,
            "end" => $clase->horaClase
        );

        return response()->json($objetoClase);
    }

    /**
     * obtener los horarios disponibles por  materia
     */
    public function getHorariosDispForMateria($idMateria)
    {
        $numeroDias = Horarios::getHorariosDiasForMaterias($idMateria);
        $fechaActual = date('d-m-Y');
        $fechaInicio =  date("d-m-Y", strtotime($fechaActual."+ 1 days")); //? se declara la fecha actual 
        $fechaFinal = date("d-m-Y", strtotime($fechaActual."+ 3 month")); 

        $infoFinal = array();
        foreach ($numeroDias as $numeroDia) {
            
            $listFechas = SELF::getFechaDias($numeroDia->numeroDia, $fechaInicio, $fechaFinal);
            
            $objetoFinal = [
                "numeroDia" => $numeroDia->numeroDia,
                "fechas" => $listFechas
            ];

            array_push($infoFinal, $objetoFinal);
        }

        $eventos = SELF::getEvetosDisponibles($infoFinal);

        return $eventos;
    }

    /**
     * obtener fechas de 3 meses
     */
    public function getFechaDias($numeroDia, $fechaInicio, $fechaFin)
    {
        //!funcion para obtener dias de la semana
        $numeroFechaInicio = strtotime($fechaInicio);
        $numeroFechaFin = strtotime($fechaFin);
        //Recorro las fechas y con la función strotime obtengo los lunes
        $arrayFechas = array();
        for ($i = $numeroFechaInicio; $i <= $numeroFechaFin; $i += 86400) {
            //Sacar el dia de la semana con el modificador N de la funcion date
            $dia = date('N', $i);
            if ($dia == $numeroDia) {

                $objeto = [
                    "fecha" => date("Y-m-d", $i)
                ];

                array_push($arrayFechas, $objeto);
            }
        }

        return json_encode($arrayFechas);
    }

    /**
     * get eventos de clases disponibles
     */
    public function getEvetosDisponibles($infoFinal)  
    {

        //dd(json_decode($infoFinal[0]['fechas']));

        $eventos = array();

        for ($i=0; $i < sizeof($infoFinal); $i++) { 
            
            $fechas = json_decode($infoFinal[$i]['fechas']);

            for ($j=0; $j < sizeof($fechas); $j++) { 

                $objeto = [
                    "title" => "Disponible",
                    "color" => "#10c469",
                    "start" => $fechas[$j]->fecha,
                    "end" => $fechas[$j]->fecha,
                    "number" => $infoFinal[$i]['numeroDia']
                ];

                array_push($eventos, $objeto);
            }
        }

        return json_encode($eventos);
    }
}
