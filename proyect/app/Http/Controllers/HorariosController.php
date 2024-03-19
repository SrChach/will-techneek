<?php

namespace App\Http\Controllers;

date_default_timezone_set('America/Mexico_City');

use App\Models\Clases;
use App\Models\Horarios;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HorariosController extends Controller
{

    public function obtenerHorariosForClase($idMateria)
    {
        $arrayDias = Horarios::horarioMateriaGoup($idMateria);
        $arrayFinal = array();

        foreach ($arrayDias as $key) {
            $arrayFechas = SELF::obtenerFechasForDia($key->dia);

            array_push($arrayFinal, $arrayFechas);
        }

        return response()->json($arrayFinal);
    }

    public function obtenerFechasForDia($idDia)
    {
        //echo 'el idDia es ' . $idDia;
        $fechaInicio = strtotime(date('Y-m-d'));
        $fechaFinal = strtotime(SELF::calculoTresMeses());
        $arrayFechas = array();

        //Recorro las fechas y con la función strotime obtengo los lunes
        for ($i = $fechaInicio; $i <= $fechaFinal; $i += 86400) {
            //Sacar el dia de la semana con el modificador N de la funcion date
            $dia = date('N', $i);
            if ($dia == $idDia) {
                array_push($arrayFechas, date("Y-m-d", $i));
            }
        }

        return $arrayFechas;
    }

    public function calculoTresMeses()
    {

        $d = time();

        $fecha = date("Y-m-d", strtotime("+3 Months", $d));

        return $fecha;
    }

    public function obtenerHorariosPorFecha(Request $request)
    {

        $idDia = date('N', strtotime($request->fecha));
        // $idDia = date('N', strtotime($fecha));

        $horarios = Horarios::horariosSegunDia($idDia);

        if (sizeof($horarios) > 0) {
            $cont = 0;
            $horariosDisponibles = array();
            foreach ($horarios as $key) {
                $obtenerClase = Clases::getClaseForHoraAndFecha($request->fecha, $key->hora_inicio);

                if ($obtenerClase == null) {
                    $cont = $cont + 1;
                    //no hay clases agendadas ese dia con esa hora

                    $arrayElements = [
                        "id" => $key->id,
                        "hora_inicio" => $key->hora_inicio, 
                        "hora_final" => $key->hora_final
                    ];

                    array_push($horariosDisponibles, $arrayElements);
                }
            }

            if (sizeof($horariosDisponibles) > 0) {
                $respuesta['estado'] = true;
                $respuesta['horariosDisponibles'] = $horariosDisponibles;
            } else {
                $respuesta['estado'] = false;
                $respuesta['mensaje'] = "No hay horarios disponibles en la fecha indicada. Intenta de nuevo.";
            }

        } else {

            $respuesta['estado'] = false;
            $respuesta['mensaje'] = "No hay horarios disponibles en la fecha indicada. Intenta de nuevo.";

        }

        return response()->json($respuesta);

    }
}
