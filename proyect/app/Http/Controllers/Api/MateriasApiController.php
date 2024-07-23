<?php

namespace App\Http\Controllers\Api;

use App\Application\Clases\Materia;
use App\Application\Clases\Tema;
use App\Exceptions\MateriasException;
use App\Http\Controllers\Controller;
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

    /**
     * @OA\Get(
     *      path="/api/materias/{materiaId}/profesores",
     *      tags={"materias"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\Parameter(
     *          in="path",
     *          name="materiaId",
     *          required=true,
     *          @OA\Schema(type="string")
     *      ),
     *      summary="Profesores asignados",
     *      description="Devuelve un listado de materias",
     *      @OA\Response(
     *          response=200,
     *          description="Successful Operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items()
     *          )
     *      )
     * )
     */
    public function getProfesores($materiaId) {
        return Materia::getUsuariosByRole($materiaId, Roles::PROFESOR);
    }
    
    public function getAlumnos($materiaId) {
        return Materia::getUsuariosByRole($materiaId, Roles::ALUMNO);
    }

    /**
     * @OA\Post(
     *      path="/api/materias",
     *      tags={"materias"},
     *      security={{ "bearerAuth": {} }},
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/Materias")
     *          ),
     *      ),
     *      summary="Crear Materia",
     *      description="Crea una materia",
     *      @OA\Response(
     *          response=201,
     *          description="Successful Operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(type="string")
     *          )
     *      )
     * )
     */
    public function store(Request $request) {
        $materia = Materia::create($request->nombre, $request->urlIcon, $request->costo);

        $temas = Tema::create($materia->id, $request->temas);
        if (!$temas) {
            throw MateriasException::notCreated();
        }

        return response()->json($materia, 201);
    }

}
