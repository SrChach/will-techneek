<?php

namespace App\Http\Controllers;

use App\Models\Archivos;
use App\Models\BitacorasAlumno;
use App\Models\BitacorasClases;
use App\Models\Clases;
use App\Models\Pedidos;
use App\Models\TiposArchivos;
use App\Models\BitacorasProfesor;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class BitacoraProfesorController extends Controller
{

    public function show($idClase)
    {
        $infoAlumnoCalificado = Pedidos::getAlumnoForClase($idClase);
        $infoFichaAlumno = BitacorasAlumno::getInfoFichaAlumno($idClase);
        $promedioProfesor = BitacorasProfesor::avgProfesor(Auth::user()->id);
        $promedioAlumno = BitacorasAlumno::avgAlumno($infoFichaAlumno->idAlumno);
        $promedioFinalProfesor = $promedioProfesor->calificacion;
        $promedioFinalAlumno = $promedioAlumno->calificacion;
        $infoClase = Clases::getFichaClase($idClase);
        $fechaFormateada = app(FechaController::class)->formatearFecha($infoClase->fecha, $infoClase->hora);
        $infoFichaClase = BitacorasClases::where('idClase', $idClase)->first();
        $archivos = Archivos::where('idClase', $idClase)->get();
        $infoDia = app(FechaController::class)->diaSemana($fechaFormateada['diaSemana']);
        $infoMes = app(FechaController::class)->mesNombre($fechaFormateada['numeroMes']);

        return view('fichas.profesor', [
            "infoFichaAlumno" => $infoFichaAlumno,
            "infoClase" => $infoClase,
            "fechaFormateada" => $fechaFormateada,
            "promedioFinalProfesor" => $promedioFinalProfesor,
            "promedioFinalAlumno" => $promedioFinalAlumno,
            "infoAlumnoCalificado" => $infoAlumnoCalificado,
            "infoFichaClase" => $infoFichaClase,
            "archivos" => $archivos,
            "infoDia" => $infoDia,
            "infoMes" => $infoMes
        ]);
    }

    public function enviarObservaciones(Request $request, $idClase)
    {
        $bitacoraClaseInfo = BitacorasClases::where('idClase', $idClase)->first();
        $bitacoraClase = BitacorasClases::find($bitacoraClaseInfo->id);
        $bitacoraClase->observaciones_profesor = $request->observacion;
        $bitacoraClase->save();

        $respuesta['mensaje'] = "Tus observaciones han sido enviadas con éxito";

        return response()->json($respuesta);
    }

    public function subirMateriales(Request $request, $idClase, $condicion)
    {

        $file = $request->file('materiales');
        switch ($condicion) {
            case '1':
                $tipo = TiposArchivos::MATERIAL;
                $path = $request->file('materiales')->store(
                    Auth::user()->id . '/' . $idClase,
                    'materiales'
                );
                $ruta = Storage::disk('materiales')->url($path);
                break;
            case '2':
                $tipo = TiposArchivos::TAREA;
                $path = $request->file('materiales')->store(
                    'tareas/' . Auth::user()->id . '/' . $idClase,
                    'public'
                );
                $ruta = Storage::disk('public')->url($path);
                break;
            default:
                $tipo = TiposArchivos::MATERIAL;
                break;
        }

        $archivo = new Archivos();
        $archivo->idClase = $idClase;
        $archivo->idTipo = $tipo;
        $archivo->url = $ruta;
        $archivo->descripcion = $request->descripcion;
        $archivo->extension = $file->getClientOriginalExtension();
        $archivo->save();

        return redirect()->back();
    }

    public function deleteMateriales($idArchivo)
    {
        $archivo = Archivos::find($idArchivo);
        $archivo->delete();

        return redirect()->back();
    }

    public function enviarObservacionesFinales(Request $request, $idClase) 
    {
        $bitacoraClaseInfo = BitacorasClases::where('idClase', $idClase)->first();
        $bitacoraClase = BitacorasClases::find($bitacoraClaseInfo->id);
        $bitacoraClase->observaciones_finales = $request->observacionfinal;
        $bitacoraClase->save();

        $respuesta['mensaje'] = "Tus observaciones finales han sido enviadas con éxito";

        return response()->json($respuesta);
    }
}
