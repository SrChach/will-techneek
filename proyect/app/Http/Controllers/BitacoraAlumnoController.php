<?php

namespace App\Http\Controllers;

use App\Models\Archivos;
use App\Models\BitacorasAlumno;
use App\Models\BitacorasClases;
use App\Models\BitacorasProfesor;
use Illuminate\Support\Facades\Auth;
use App\Models\Clases;
use Illuminate\Http\Request;

class BitacoraAlumnoController extends Controller
{
    
    public function show($idClase) 
    {
        $infoFichaProfesor = BitacorasProfesor::getInfoFichaProfesor($idClase);
        //dd($infoFichaProfesor);
        $promedioProfesor = BitacorasProfesor::avgProfesor($infoFichaProfesor->idProfesor);
        $promedioAlumno = BitacorasAlumno::avgAlumno(Auth::user()->id);
        $promedioFinal = $promedioProfesor->calificacion;
        $promedioFinalAlumno = $promedioAlumno->calificacion;
        $infoClase = Clases::getFichaClase($idClase);
        $infoFichaClase = BitacorasClases::where('idClase', $idClase)->first();
        $fechaFormateada = app(FechaController::class)->formatearFecha($infoClase->fecha, $infoClase->hora);
        $archivos = Archivos::where('idClase', $idClase)->get();
        $infoDia = app(FechaController::class)->diaSemana($fechaFormateada['diaSemana']);
        $infoMes = app(FechaController::class)->mesNombre($fechaFormateada['numeroMes']);

        return view('fichas.alumno', [
            "infoFichaProfesor" => $infoFichaProfesor, 
            "infoClase" => $infoClase,
            "fechaFormateada" => $fechaFormateada,
            "infoFichaClase" => $infoFichaClase,
            "promedioFinal" => $promedioFinal,
            "promedioFinalAlumno" => $promedioFinalAlumno,
            "archivos" => $archivos,
            "infoDia" => $infoDia,
            "infoMes" => $infoMes
        ]);

    }

}
