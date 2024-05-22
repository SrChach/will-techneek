<?php

namespace App\Http\Controllers;

use App\Application\Horario;
use App\Exceptions\ClasesException;
use App\Exceptions\PedidosException;
use App\Exceptions\UserException;
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
use App\Models\Pedidos;
use App\Models\Roles;

class AlumnoApiController extends Controller
{

    public $listAlumnos = array();
    public $sujeto;

    public function index()
    {
        $alumnos = User::where('idRol', Roles::ALUMNO)->get();
        
        return response()->json($alumnos);
    }

    public function pedidos($idAlumno) {
        $pedidos = Pedidos::where('idAlumno', $idAlumno)
            ->with('clases')
            ->get();

        if (!$pedidos) {
            throw PedidosException::sinPedidos();
        }

        return response()->json($pedidos);
    }

    public function horarios($idAlumno)
    {
        $alumnos = User::where('idRol', Roles::ALUMNO)
            ->where('id', $idAlumno)
            ->with('horarios')
            ->get();
        
        return response()->json($alumnos);
    }

    public function addHorario($idAlumno, Request $request)
    {
        $dia = $request->dia;
        $hora = $request->hora;

        $horario = Horario::addHorario($idAlumno, $dia, $hora);

        return response()->json($horario, 201);
    }

    /**
     * 
     * funcion donde se eliminan los horarios
     * 
     */
    public function deleteHorario($idAlumno, Request $request)
    {
        $dia = $request->dia;

        $horaInicio = date("H:i:s", strtotime($request->hora));
        Horario::deleteHorario($idAlumno, $dia, $horaInicio);

        return response()->json(null, 204);
    }

    public function programarClase($idAlumno, $idClase, Request $request)
    {
        $fecha = $request->dia;
        $hora_inicio = $request->hora;
        $idProfesor = $request->idProfesor;

        // TODO tomar horario del perfil, por ID de horario
        // TODO manage conferences
        // $linkConference = $request->linkConference;

        $clase = Clases::where('id', $idClase)
            ->with('pedido')
            ->first();

        if (!$clase) {
            throw ClasesException::sinClase();
        }

        // TODO mejorar validacion
        if ($clase->idEstados == EstadosClases::PROGRAMADA) {
            throw ClasesException::yaAgendada();
        }

        $clase->idEstados = EstadosClases::PROGRAMADA;
        $clase->idProfesor = $idProfesor;
        $clase->fecha = $fecha;
        $clase->hora = $hora_inicio;
        $clase->save();

        return response()->json($clase, 200);
    }

    public function clasesPorAlumno($idAlumno, Request $request)
    {
        // TODO filtrar por clases no impartidas, o pendientes por asignar
        $alumno = User::where('idRol', Roles::ALUMNO)
            ->where('id', $idAlumno)
            ->first();
        
        if (!$alumno) {
            throw UserException::notFound();
        }

        $clasesDelAlumno = $alumno->clases;
        return response()->json($clasesDelAlumno, 200);
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
