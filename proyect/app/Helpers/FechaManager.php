<?php

namespace App\Helpers;

class FechaManager
{
    
    public static function formatearFecha($fecha, $hora)
    {
        $fechaCompleta = $fecha . ' ' . $hora;
        $timeNumber = strtotime($fechaCompleta);

        $diaMes = date('d', $timeNumber);
        $diaSemana = date('N', $timeNumber);
        $numeroMes = date('n', $timeNumber);
        $horaAtrr = date('a', $timeNumber);
        $horaCeros = date('h', $timeNumber);
        $year = date('Y', $timeNumber);

        $formato = [
            "diaMes" => $diaMes,
            "diaSemana" => $diaSemana,
            "numeroMes" => $numeroMes,
            "horaAtrr" => $horaAtrr,
            "horaCeros" => $horaCeros,
            "year" => $year,
        ];

        return $formato;
    }

    public static function diaSemana($numeroDia)  
    {
        $listDias = ["Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado", "Domingo"];
        $listAbrt = ["Lun", "Mar", "Mier","Jue", "Vie", "Sab", "Dom"];

        $cont = 0;
        for ($i=0; $i <= 6; $i++) { 
            $cont = $cont + 1;

            if ($numeroDia == $cont) {
                $arrayDia = array(
                    "nombreDiaSemana" => $listDias[$i],
                    "diaSemanaAbrt" => $listAbrt[$i],
                );
            }
        }

        return $arrayDia;
    }

    public static function mesNombre($numeroMes)  
    {
        $listMes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        $lisMesAbrt = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sept", "Oct", "Nov", "Dic"];

        $cont = 0;
        for ($i=0; $i <= 11; $i++) { 
            $cont = $cont + 1;
            
            if ($numeroMes == $cont) {
                $arrayMes = [
                    "nombreMes" => $listMes[$i],
                    "mesAbrtNombre" => $lisMesAbrt[$i]
                ];
            }
        }

        return $arrayMes;
    }

}
