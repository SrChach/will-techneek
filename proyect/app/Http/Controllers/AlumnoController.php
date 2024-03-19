<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\EstadosUsuarios;
use App\Models\Materias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use PhpParser\Builder\Class_;


use App\Models\BitacorasAlumno;


class AlumnoController extends Controller
{

    public $listAlumnos = array();
    public $sujeto;

    //! metodos para el admin
    /**
     * 
     * funcion donde se enlistan todos los alumnos para el admin
     * 
     */
    public function index()
    {
		
        $alumnos = User::where('idRol', 3)->get();

        $listaAlumnos = array();

        foreach ($alumnos as $alumno) {
            $countImpartidas = Clases::clasesCountForAlumno($alumno->id, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::clasesCountForAlumno($alumno->id, EstadosClases::PROGRAMADA);

            $objetoAlumno = array(
                "idAlumno" => $alumno->id,
                "nombreAlumno" => $alumno->nombre,
                "apellidosAlumno" => $alumno->apellidos,
                "correoAlumno" => $alumno->email,
                "fotoAlumno" => $alumno->foto,
                "countImpartidas" => $countImpartidas,
                "countProgramadas" => $countProgramadas
            );

            array_push($listaAlumnos, $objetoAlumno);
        }
        return view('admin.alumnos.listar', [
            "listaAlumnos" => $listaAlumnos
        ]);
    }


    /**
     * 
     * funcion donde se enlistan la informacion de un alumno seleccionado para el @admin
     * 
     */
    public function show($id)
    {
        $condicion = 'pedidos.idAlumno';
        $alumno = User::find($id);
        $clasesProgramadas = Clases::clasesCountForAlumno($id, 2);
        $infoClasProg = Clases::clasesInfoForUsuario($condicion, $id, 2);
        $clasesTomadas = Clases::clasesCountForAlumno($id, 4);
        $infoClasImpar = Clases::clasesInfoForUsuario($condicion, $id, 4);
        $totalCosto = Clases::getTotalCosto($condicion, $id);
		
		
		$avgAlumno = BitacorasAlumno::avgAlumno($id);
		
		
		/*echo "<pre>";
		print_r($avgAlumno);
		echo "</pre>";*/
        return view('admin.alumnos.show', [
            "alumno" => $alumno,
            "clasesProgramadas" => $clasesProgramadas,
            "clasesTomadas" => $clasesTomadas,
            "totalCosto" => $totalCosto,
            "infoClasProg" => $infoClasProg,
            "infoClasImpar" => $infoClasImpar,
			"avgAlumno"=>$avgAlumno
        ]);
    }

    /**
     * obtener alumnos segun una relacion (materias, profesores)
     */

    public function alumnosForCondicion($id, $condicion)
    {
        switch ($condicion) {
                /**
             * Obteniene la lista de alumnos por materia, junto con los sig contadores
             * Contador de clases impartidas de esa materia a cada alumno de la lista
             * Contador de clases programadas de esa materia a cada alumno de la lista
             */
            case '1':
                $alumnos = Materias::getInfoAlumnosForMateria($id);
                $this->sujeto = Materias::find($id);

                foreach ($alumnos as $alumno) {
                    $countImpartidas = Clases::getCountClasesForMateriaAndUsuario($id, EstadosClases::IMPARTIDA, $alumno->idUsuario);
                    $countProgramadas = Clases::getCountClasesForMateriaAndUsuario($id, EstadosClases::PROGRAMADA, $alumno->idUsuario);

                    $objetoAlumno = array(
                        "idAlumno" => $alumno->idUsuario,
                        "nombreAlumno" => $alumno->nombreUsuario,
                        "apellidosAlumno" => $alumno->apellidosUsuario,
                        "correoAlumno" => $alumno->correoUsuario,
                        "fotoAlumno" => $alumno->fotoUsuario,
                        "countImpartidas" => $countImpartidas,
                        "countProgramadas" => $countProgramadas
                    );

                    array_push($this->listAlumnos, $objetoAlumno);
                }

                break;

                /**
                 * Obtiene la lista de alumnos relacionados con un profesor, con los sig contadores
                 * Contador de clases impartidas de ese profesor con cada alumno relacionado
                 * Contador de clases programadas de ese profesor con cada alumno relacionado
                 */
            case '2':
                $this->sujeto = User::find($id);
                $alumnos = User::getAlumnosForProfesor($id);

                foreach ($alumnos as $alumno) {

                    $countImpartidas = Clases::getCountClasesForAlumnosAndProfesor($alumno->idUser, $id, EstadosClases::IMPARTIDA);
                    $countProgramadas = Clases::getCountClasesForAlumnosAndProfesor($alumno->idUser, $id, EstadosClases::PROGRAMADA);

                    $objetoAlumno = array(
                        "idAlumno" => $alumno->idUser,
                        "nombreAlumno" => $alumno->nombre,
                        "apellidosAlumno" => $alumno->apellidos,
                        "correoAlumno" => $alumno->correo,
                        "fotoAlumno" => $alumno->foto,
                        "countImpartidas" => $countImpartidas,
                        "countProgramadas" => $countProgramadas
                    );

                    array_push($this->listAlumnos, $objetoAlumno);
                }

                break;
        }

        return view('admin.alumnos.condicion', [
            "sujeto" => $this->sujeto,
            "listAlumnos" => $this->listAlumnos,
            "condicion" => $condicion
        ]);
    }

    //? metodos del profesor
    /**
     * 
     * funcion donde se enlistan todos los alumnos para el profesor
     * 
     */
    public function alumnosProfesor()
    {
        $condicion = 2;
        $idProfesor = Auth::user()->id;
        $this->sujeto = Auth::user();
        $alumnos = User::getAlumnosForProfesor($idProfesor);

        foreach ($alumnos as $alumno) {
            $countImpartidas = Clases::getCountClasesForAlumnosAndProfesor($alumno->idUser, $idProfesor, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::getCountClasesForAlumnosAndProfesor($alumno->idUser, $idProfesor, EstadosClases::PROGRAMADA);

            $objetoAlumno = array(
                "idAlumno" => $alumno->idUser,
                "nombreAlumno" => $alumno->nombre,
                "apellidosAlumno" => $alumno->apellidos,
                "correoAlumno" => $alumno->correo,
                "fotoAlumno" => $alumno->foto,
                "countImpartidas" => $countImpartidas,
                "countProgramadas" => $countProgramadas
            );

            array_push($this->listAlumnos, $objetoAlumno);
        }

        return view('admin.alumnos.condicion', [
            "sujeto" => $this->sujeto,
            "listAlumnos" => $this->listAlumnos,
            "condicion" => $condicion
        ]);
    }

    /**
     * 
     * funcion donde se enlistan la informacion de un alumno seleccionado para el profesor
     * 
     */
    public function fichaAlumnoForProfesor($id)
    {
        $alumno = User::find($id);
        $countImpartidas = Clases::getCountClasesForAlumnosAndProfesor($id, Auth::user()->id, EstadosClases::IMPARTIDA);
        $countProgramadas = Clases::getCountClasesForAlumnosAndProfesor($id, Auth::user()->id, EstadosClases::PROGRAMADA);
        $clasesInfoProgramadas = Clases::getInfoClasesForAlumnoAndProfesor(Auth::user()->id, $id, EstadosClases::PROGRAMADA);
        $clasesInfoImpartidas = Clases::getInfoClasesForAlumnoAndProfesor(Auth::user()->id, $id, EstadosClases::IMPARTIDA);
        $materiasWithAlumno = Materias::getMateriasForAlumnoWith($id, Auth::user()->id);

        return view('profesores.alumnos.show', [
            "alumno" => $alumno,
            "countImpartidas" => $countImpartidas,
            "countProgramadas" => $countProgramadas,
            "clasesInfoProgramadas" => $clasesInfoProgramadas,
            "clasesInfoImpartidas" => $clasesInfoImpartidas,
            "materiasWithAlumno" => $materiasWithAlumno
        ]);
    }

    //* metodos de buscador
    public function buscarAlumno(Request $request)
    {

        $alumnos = User::where('nombre', 'like', '%' . $request->search . '%')
		->orWhere('apellidos', 'like', '%' . $request->search . '%')
		->get();

        return json_decode($alumnos);
    }

    public function ordenar(Request $request)
    {
        $orden = $request->orden;
        $alumnos = User::where('idRol', 3)->orderBy('nombre', $orden)->get();

        $listaAlumnos = array();

        foreach ($alumnos as $alumno) {
            $countImpartidas = Clases::clasesCountForAlumno($alumno->id, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::clasesCountForAlumno($alumno->id, EstadosClases::PROGRAMADA);

            $objetoAlumno = array(
                "idAlumno" => $alumno->id,
                "nombreAlumno" => $alumno->nombre,
                "apellidosAlumno" => $alumno->apellidos,
                "correoAlumno" => $alumno->email,
                "fotoAlumno" => $alumno->foto,
                "countImpartidas" => $countImpartidas,
                "countProgramadas" => $countProgramadas
            );

            array_push($listaAlumnos, $objetoAlumno);
        }

        return response()->json($listaAlumnos);
    }
}
