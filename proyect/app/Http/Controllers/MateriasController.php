<?php

namespace App\Http\Controllers;

use App\Models\Materias;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\EstadosPagos;
use App\Models\Pedidos;
use App\Models\Roles;
use App\Models\Temas;
use App\Models\UsuariosMaterias;
use Illuminate\Cache\RateLimiting\Limit;

class MateriasController extends Controller
{

    /**
     * funcion de listado de materias
     * 
     * retorna vista
     */
    public function index(): View
    {

        $materias = Materias::all();

        $listaMaterias = array();

        foreach ($materias as $materia) {
            $countImpartidas = Clases::getClasesForMateriaCount($materia->id, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::getClasesForMateriaCount($materia->id, EstadosClases::PROGRAMADA);
            $countAlumnos = Pedidos::getCoutAlumnosForMateria($materia->id);

            $objetoMateria = array(
                "idMateria" => $materia->id,
                "nombreMateria" => $materia->nombre,
                "iconoMateria" => $materia->icono,
                "alumnos" => $countAlumnos,
                "clasesImpartidas" => $countImpartidas,
                "clasesProgramadas" => $countProgramadas
            );

            array_push($listaMaterias, $objetoMateria);
        }

        return view('admin.materias.listar', [
            "listaMaterias" => $listaMaterias
        ]);
    }

    /**
     * funcion de listado de materias
     * 
     * retorna vista
     */
    public function create(): View
    {

        return view('admin.materias.create');
    }

    /**
     * funcion para agregar materia
     * 
     * 
     */
    public function store(Request $request)
    {
        //? guadamos los arreglos de la innformacion de los temas
        $titulos = $request->titulo;
        $numeros = $request->numero;

        //* guardamos el icon de la materia y generamos la url del icono para guardarlo en la base de datos
        $urlIcon = app(FileController::class)->subirIconMateria($request->file('icono'));

        //? creamos la materia 
        Materias::create([
            'nombre' => $request->nombre,
            'icono' => $urlIcon,
            'costo' => $request->costo
        ]);

        //? obtenemos la información de la materia que se acaba de insertar 
        $infoMateria = Materias::latest()->first();
        app(TemasController::class)->addTema($infoMateria, $titulos, $numeros, 0);

        $respuesta['estado'] = true;
        $respuesta['mensaje'] = "Materia Registrada";

        return response()->json($respuesta);
    }

    /**
     * funcion que retorna la informacion de la materia
     * 
     * retorna vista
     */
    public function show($id)
    {
        $condicion = "pedidos.idMateria";
        $materia = Materias::find($id);
        $temas = Temas::where('idMateria', $id)->take(5)->get();
        $countAlumnos = Materias::alumnosForMateria($id);
        $countClasesImpartidas = Clases::getClasesForMateriaCount($id, EstadosClases::IMPARTIDA);
        $countClasesProgramadas = Clases::getClasesForMateriaCount($id, EstadosClases::PROGRAMADA);
        $infoClasesImpartidas = Clases::clasesInfoForUsuario($condicion, $id, EstadosClases::IMPARTIDA);
        $infoClasesProgramadas = Clases::clasesInfoForUsuario($condicion, $id, EstadosClases::PROGRAMADA);
        $infoProfesores = UsuariosMaterias::getLastUsuariosForMateria($id, Roles::PROFESOR);
        $total = Clases::getTotalCostoMateria($id);

        return view('admin.materias.show', [
            'materia' => $materia,
            'temas' => $temas,
            'countAlumnos' => $countAlumnos,
            'countClasesImpartidas' => $countClasesImpartidas,
            'countClasesProgramadas' => $countClasesProgramadas,
            "infoClasesImpartidas" => $infoClasesImpartidas,
            "infoClasesProgramadas" => $infoClasesProgramadas,
            "infoProfesores" => $infoProfesores,
            'total' => number_format($total)
        ]);
    }

    /**
     * funcion que retorna la informacion de la materia para edicion
     * 
     * retorna vista
     */
    public function edit($id)
    {

        $materia = Materias::find($id);
        $temas = Temas::where('idMateria', $id)->get();

        return view('admin.materias.edit', [
            'materia' => $materia,
            'temas' => $temas
        ]);
    }

    /**
     * funcion que actualiza la informacion de la materia seleccionada
     * 
     * retorna vista
     */
    public function update(Request $request, $id)
    {
        //lista 
        $titulos = $request->titulo;
        $numeros = $request->numero;
        //datos normales 
        $materia = Materias::find($id);
        $materia->nombre = $request->nombre;
        $materia->costo = $request->costo;
        //verifica si existe el archivo
        if (isset($request->icono)) {
            $urlMateria = app(FileController::class)->subirIconMateria($request->file('icono'));
            $materia->icono = $urlMateria;
        } else {
            $materia->icono = $materia->icono;
        }
        $materia->save();
        Temas::where('idMateria', $id)->delete();
        app(TemasController::class)->addTema($materia, $titulos, $numeros);

        return redirect()->route('materia.show', $id);
    }


    //! metodos para los alumnos

    public function getFichaMateriaAlumno()  
    {
        
    }
	
	
	//* metodos de buscador
    public function buscarMateria(Request $request)
    {
        $materias = Materias::where('nombre', 'like', '%' . $request->search . '%')->get();

        return json_decode($materias);
    }
	
	public function ordenar(Request $request)
    {
        $orden = $request->orden;
        $materias = Materias::orderBy('nombre', $orden)->get();

        $listaAlumnos = array();

        foreach ($materias as $materia) {
            $countImpartidas = Clases::getClasesForMateriaCount($materia->id, EstadosClases::IMPARTIDA);
            $countProgramadas = Clases::getClasesForMateriaCount($materia->id, EstadosClases::PROGRAMADA);
            $countAlumnos = Pedidos::getCoutAlumnosForMateria($materia->id);

            $objetoAlumno = array(
                "idMateria" => $materia->id,
                "nombreMateria" => $materia->nombre,
                "fotoMateria" => $materia->icono,
                "countImpartidas" => $countImpartidas,
                "countProgramadas" => $countProgramadas,
                "countAlumnos" => $countAlumnos
            );

            array_push($listaAlumnos, $objetoAlumno);
        }

        return response()->json($listaAlumnos);
    }

    
}
