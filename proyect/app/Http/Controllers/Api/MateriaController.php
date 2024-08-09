<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materias;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *      title="API Swagger",
 *      version="1.0",
 *      description="API CRUD Materias"
 * )
 * @OA\Server(url=L5_SWAGGER_CONST_HOST)
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 * ),
 * @OA\Tag(
 *     name="Auth",
 *     description="Endpoints de Autenticación",
 * )
 * @OA\Tag(
 *     name="materias",
 *     description="Endpoints de Materias",
 * )
 */

class MateriaController extends Controller
{


    /**
     * @OA\Get(
     *      path="/api/materias",
     *      tags={"materias"},
     *      summary="List of all materias",
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
    public function getMateria($idMateria)
    {
        $materia = Materias::find($idMateria);

        return response()->json($materia);
    }

}
