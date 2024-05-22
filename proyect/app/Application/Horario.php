<?php

namespace App\Application;

use App\Exceptions\HorarioException;
use App\Models\Horarios;

class Horario {

    public static function addHorario($idUsuario, $dia, $hora)
    {
        $horaInicio = date("H:i:s", strtotime($hora));
        $horaFinal = date('H:i:s', strtotime('+1 hour', strtotime($horaInicio)));

        $existentHorario = Horarios::where('idUsuario', $idUsuario)
            ->where('idDias', $dia)
            ->where('hora_inicio', $horaInicio)
            ->first();

        if (isset($existentHorario)) {
            throw HorarioException::existentHorario();
        }

        $horario = new Horarios();
        $horario->idUsuario = $idUsuario;
        $horario->idDias = $dia;
        $horario->hora_inicio = $horaInicio;
        $horario->hora_final = $horaFinal;
        $horario->save();

        return $horario;
    }

    /**
     * 
     * funcion donde se eliminan los horarios
     * 
     */
    public static function deleteHorario($idUsuario, $dia, $hora)
    {
        $horaInicio = date("H:i:s", strtotime($hora));

        $existentHorario = Horarios::where('idUsuario', $idUsuario)
            ->where('idDias', $dia)
            ->where('hora_inicio', $horaInicio)
            ->first();

        if (!$existentHorario) {
            throw HorarioException::notFound();
        }

        $existentHorario->delete();
    }

}