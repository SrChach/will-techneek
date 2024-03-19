<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\Materias;
use App\Models\User;
use Illuminate\Http\Request;

class FiltroController extends Controller
{

    public function filtro(Request $request)
    {
        $estados = EstadosClases::all();
        $estado = $request->estado;
        $inicio = $request->fechaInicio;
        $fin = $request->fechaFin;

        $clases = Clases::getClasesForFiltroAll($estado, $inicio, $fin);

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

    static function filtroForCondicion(Request $request, $id, $condicion)
    {

        $estados = EstadosClases::all();
        $estado = $request->estado;
        $inicio = $request->fechaInicio;
        $fin = $request->fechaFin;
        $estadoFinal = $condicion;

        //? se establece la condicion del filtro segun la condicion
        switch ($condicion) {
            case '0':
                $condicion = '';
                $id = 1;
                break;
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
                $condicion = 'clases.idProfesor'; //! 3 es para alumno
                $infomacion = User::find($id);
                $encabezados = array('ID CLASE', 'MATERIA', 'FECHA <br> HORA', 'PAGO <br> CLASE', 'ESTADO <br> CLASE', 'LINKS');
                break;
        }


        $clases = Clases::getClasesForFechaAndCodicion($estado, $inicio, $fin, $condicion, $id);

        $clasesList = array();
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
                "fecha" => $clase->fechaClase,
                "hora" => $clase->horaClase,
                "idEstadoClase" => $clase->idEstadoClase,
                "nombreEstado" => $clase->estado,
                "etiquetaEstados" => $clase->etiqueta,
                "nombreMateria" => $clase->nombreMateria,
                "idProfesor" => $clase->idProfesor,
                "idAlumno" => $clase->idAlumno,
                "pago" => $clase->pago,
                "link" => $clase->link,
                "nombreAlumno" => $nombreAlumno,
                "nombreProfesor" => $nombreProfesor
            ];

            array_push($clasesList, $objetoClase);
        }

        $estados = EstadosClases::all();

        return view('admin.clases.condicion', [
            "indicador" => $estadoFinal,
            "clasesList" => $clasesList,
            "informacion" => $infomacion,
            "encabezados" => $encabezados,
            "estados" => $estados
        ]);
    }
}
