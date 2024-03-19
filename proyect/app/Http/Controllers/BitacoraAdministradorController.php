<?php

namespace App\Http\Controllers;

use App\Mail\PagoRegistradoProfesorMailer;
use App\Models\Archivos;
use App\Models\BitacorasAlumno;
use App\Models\BitacorasClases;
use App\Models\BitacorasProfesor;
use App\Models\Clases;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BitacoraAdministradorController extends Controller
{

    public function show($idClase)
    {
        $infoFichaProfesor = BitacorasProfesor::getInfoFichaProfesor($idClase);
        $infoFichaAlumno = BitacorasAlumno::getInfoFichaAlumno($idClase);
        $promedioProfesor = BitacorasProfesor::avgProfesor($infoFichaProfesor->idProfesor);
        $promedioAlumno = BitacorasAlumno::avgAlumno($infoFichaAlumno->idAlumno);
        $infoClase = Clases::getFichaClase($idClase);
        $archivos = Archivos::where('idClase', $idClase)->get();
        $infoFichaClase = BitacorasClases::where('idClase', $idClase)->first();
        $fechaFormateada = app(FechaController::class)->formatearFecha($infoClase->fecha, $infoClase->hora);
        $infoDia = app(FechaController::class)->diaSemana($fechaFormateada['diaSemana']);
        $infoMes = app(FechaController::class)->mesNombre($fechaFormateada['numeroMes']);


		if(!isset($infoClase)){
			$infoClase['observaciones_profesor']="";
			$infoClase['observaciones_finales']="";
		}
		return view('fichas.administrador', [ 
            "infoFichaProfesor" => $infoFichaProfesor,
            "infoFichaAlumno" => $infoFichaAlumno,
            "infoClase" => $infoClase,
            "promedioProfesor" => $promedioProfesor,
            "promedioAlumno" => $promedioAlumno,
            "archivos" => $archivos,
            "infoFichaClase" => $infoFichaClase,
            "fechaFormateada" => $fechaFormateada,
            "infoDia" => $infoDia,
            "infoMes" => $infoMes,
            "idClase" => $idClase,
			"observaciones_finales"=>"aaa"
        ]);
    }

    public function pagoProfesor(Request $request, $idClase) 
    {
        $clase = Clases::find($idClase);
        $clase->pagoProfesor = $request->cantidad;
        $clase->save();

        $idProfesor = $clase->idProfesor;
        $infoProfesor = User::find($idProfesor);

        $mensajeProfesor = "La clase N° " . $idClase . " ha sido pagada.";

        Mail::to($infoProfesor->email)->send(new PagoRegistradoProfesorMailer($idClase, $infoProfesor->id));
        app(OneSignalAlertController::class)->getDevicesForUser($mensajeProfesor, $idProfesor); 

        $respuesta['estado'] = true;
        $respuesta['mensaje'] = "El pago se ha registrado exitosamente";

        return json_encode($respuesta); 
    }
}
