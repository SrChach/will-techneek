<?php

namespace App\Http\Controllers;

use App\Models\BitacorasAlumno;
use App\Models\BitacorasClases;
use App\Models\BitacorasProfesor;
use App\Models\Clases;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BitacorasController extends Controller
{
    /**
     *  funcion para crear fichas al momento que se termina la programacion de la clase
     *  @return redirect
     */
    public function create($idClase, $idProfesor, $idAlumno)
    {

        $bitacoraAlumno = new BitacorasAlumno();
        $bitacoraAlumno->idClase = $idClase;
        $bitacoraAlumno->idAlumno = $idAlumno;
        $bitacoraAlumno->save();

        $bitacoraProfesor = new BitacorasProfesor();
        $bitacoraProfesor->idClase = $idClase;
        $bitacoraProfesor->idProfesor = $idProfesor;
        $bitacoraProfesor->save();

        $bitacoraClase = new BitacorasClases();
        $bitacoraClase->idClase = $idClase;
        $bitacoraClase->save();

        return redirect()->route('ficha.show', [$idClase, $idProfesor, $idAlumno]);
    }

    /**
     *  funcion para ver la ficha en general los elementos desapareceran segun quien consulte la ficha
     *  @return redirect
     */
    public function show($idClase)
    {

        /* $infoFichaAlumno = BitacorasAlumno::getInfoFichaAlumno($idClase, $idAlumno);
        $infoFichaProfesor = BitacorasProfesor::getInfoFichaProfesor($idClase, $idProfesor);
        $infoClase = Clases::getFichaClase($idClase);

        $fechaFormateada = app(FechaController::class)->formatearFecha($infoClase->fecha, $infoClase->hora);
        $infoDia = app(FechaController::class)->diaSemana($fechaFormateada['diaSemana']);
        $infoMes = app(FechaController::class)->mesNombre($fechaFormateada['numeroMes']);

        return view('fichas.show', [
            "infoFichaAlumno" => $infoFichaAlumno,
            "infoFichaProfesor" => $infoFichaProfesor,
            "infoClase" => $infoClase,
            "fechaFormateada" => $fechaFormateada,
            "infoDia" => $infoDia,
            "infoMes" => $infoMes
        ]); */

        if (Auth::user()->idRol == 1) {
            //dd('fiha de clase para admminstracion');
            return redirect()->route('bitacora.administrador', $idClase);
        }
        else if (Auth::user()->idRol == 2) {
            //dd("redireccionar al bitacora profesor");
            return redirect()->route('bitacora.profesor', $idClase);
        }
        else if (Auth::user()->idRol == 3) {
            //dd("redireccionar al bitacora profesor");
            return redirect()->route('bitacora.alumno', $idClase);
        }
    }

    /**
     * function para enviar su bitacora de calificacion
     */
    public function store(Request $request, $idClase, $condicion)
    {
        if ($condicion == 1) {
            $tabla = 'bitacoras_alumnos';
        } elseif ($condicion == 2) {
            $tabla = 'bitacoras_profesors';
        }

        $update = DB::table($tabla)
            ->where('idClase', $idClase)
            ->update(['calificacion' => $request->stars, 'comentarios' => $request->comentarios]);

        $respuesta['estado'] = true ;
        $respuesta['mensaje'] = "Tu calificación ha sido enviada con éxito.";

        return response()->json($respuesta); 
    }
}
