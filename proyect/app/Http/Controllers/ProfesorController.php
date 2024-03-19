<?php

namespace App\Http\Controllers;

use App\Mail\BienvenidaProfesorMailer;
use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\Horarios;
use App\Models\Materias;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

use App\Models\BitacorasProfesor;

class ProfesorController extends Controller
{
    
    /**
    * 
    * funcion donde se listan todos los profesores
    * 
    */
    public function index() 
    {
        $profesores = User::where('idRol', 2)->get();

        $listaProfesor = array();

        foreach ($profesores as $profesor) {
            $countImpartidas = Clases::clasesCountForUsuario($profesor->id, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::clasesCountForUsuario($profesor->id, EstadosClases::PROGRAMADA);

            $objetoProfesor = array(
                "idProfesor" => $profesor->id,
                "nombreProfesor" => $profesor->nombre,
                "apellidosProfesor" => $profesor->pellidos,
                "correoProfesor" => $profesor->email,
                "fotoProfesor" => $profesor->foto,
                "countImpartidas" => $countImpartidas,
                "countProgramadas" => $countProgramadas
            );

            array_push($listaProfesor, $objetoProfesor);
            
        }

        return view('admin.profesores.listar', [
            "listaProfesor" => $listaProfesor
        ]);
    }

    /**
    * 
    * funcion para agregar profesor
    * 
    */
    public function store(Request $request) 
    {
        
        $profesor = new User();

        $profesor->idStatus = 2;
        $profesor->idRol = 2;
        $profesor->nombre = $request->nombre;
        $profesor->email = $request->correo;
        $profesor->password = $request->contraseña;
        $profesor->save();

        Mail::to($request->correo)->send(new BienvenidaProfesorMailer($request->nombre, $request->correo, $request->contraseña));
        

        $respuesta['estado'] = true;
        $respuesta['mensaje'] = "Profesor añadido con exito";

        return response()->json($respuesta);

    }

    /**
    * 
    * funcion donde se muestra la informacion de un profesor seleccionado
    * 
    */
    public function show($id) 
    {
        $condicion = 'clases.idProfesor';
        $clasesProgramadas = Clases::clasesCountForUsuario($id, 2);
        $infoClasProg = Clases::clasesInfoForUsuario($condicion, $id, 2);
        $clasesImpartidas = Clases::clasesCountForUsuario($id, 4);
        $infoClasImpar = Clases::clasesInfoForUsuario($condicion, $id, 4);
        $profesor = User::find($id);
        $materiasRelacionadas = Materias::materiasForUsuario($id);
        $totalCosto = Clases::getTotalCosto($condicion, $id);
		
		$avgProfesor = BitacorasProfesor::avgProfesor($id);

        return view('admin.profesores.show', [
            "profesor" => $profesor,
            "clasesProgramadas" => $clasesProgramadas,
            "clasesImpartidas" => $clasesImpartidas,
            "infoClasProg" => $infoClasProg,
            "infoClasImpar" => $infoClasImpar,
            "materiasRelacionadas" => $materiasRelacionadas,
            "totalCosto" => $totalCosto,
			"avgProfesor"=>$avgProfesor
        ]);

    }

    //? profesores para el alumno
    public function buscarProfesores(Request $request) 
    {
        $horarioSeccion = explode("-", $request->horarios);
        $fecha = $request->fecha;
        $hora_inicio = $horarioSeccion[0];

        $idDias = date('N', strtotime($fecha));
       
        $users = User::horariosForUsers($idDias, $hora_inicio);

        return response()->json($users);
    }

    public function getFichaProfesorAlumno($idProfesor) : View
    {
        $profesor = User::find($idProfesor);
        $idProfesor = $profesor->id;
        $idAlumno = Auth::user()->id;

        $clasesProgramadasWithProfesor = User::getClasesForAlumnoWithProfesor($idAlumno, $idProfesor, 2);
        $clasesImpartidasWithProfesor = User::getClasesForAlumnoWithProfesor($idAlumno, $idProfesor, 4);
        $materiasWithProfesor = Materias::getMateriasForAlumnoWith($idAlumno, $idProfesor);

        return view('alumnos.profesor.ficha', [
            "profesor" => $profesor,
            "clasesProgramadasWithProfesor" => $clasesProgramadasWithProfesor,
            "clasesImpartidasWithProfesor" => $clasesImpartidasWithProfesor,
            "materiasWithProfesor" => $materiasWithProfesor
        ]);
    }
	
	
	//* metodos de buscador
    public function buscarProfesor(Request $request)
    {

        $alumnos = User::where('nombre', 'like', '%' . $request->search . '%')
		->orWhere('apellidos', 'like', '%' . $request->search . '%')
		->get();

        return json_decode($alumnos);
    }

    public function ordenar(Request $request)
    {
        $orden = $request->orden;
        $profesores = User::where('idRol', 2)->orderBy('nombre', $orden)->get();

        $listaProfesores = array();

        foreach ($profesores as $profesor) {
            $countImpartidas = Clases::clasesCountForUsuario($profesor->id, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::clasesCountForUsuario($profesor->id, EstadosClases::PROGRAMADA);

            $objetoProfesor = array(
                "idProfesor" => $profesor->id,
                "nombreProfesor" => $profesor->nombre,
                "apellidosProfesor" => $profesor->pellidos,
                "correoProfesor" => $profesor->email,
                "fotoProfesor" => $profesor->foto,
                "countImpartidas" => $countImpartidas,
                "countProgramadas" => $countProgramadas
            );

            array_push($listaProfesores, $objetoProfesor);
        }

        return response()->json($listaProfesores);
    }

}
