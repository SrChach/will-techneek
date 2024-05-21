<?php

namespace App\Http\Controllers;

use App\Application\Clases\Materia;
use App\Application\Clases\Tema;
use App\Exceptions\MateriasException;
use App\Models\Roles;
use Illuminate\Http\Request;

class MateriasApiController extends Controller
{

    public function index() {
        return response()->json(Materia::list());
    }

    public function fullList() {
        return response()->json(Materia::list_full());
    }

    public function getProfesores($materiaId) {
        return Materia::getUsuariosByRole($materiaId, Roles::PROFESOR);
    }
    
    public function getAlumnos($materiaId) {
        return Materia::getUsuariosByRole($materiaId, Roles::ALUMNO);
    }

    // TODO validate
    public function store(Request $request) {
        $materia = Materia::create($request->nombre, $request->urlIcon, $request->costo);

        $temas = Tema::create($materia->id, $request->temas);
        if (!$temas) {
            throw MateriasException::notCreated();
        }

        return response()->json($materia, 201);
    }

}
