<?php

namespace App\Http\Controllers;

use App\Application\Clases\Tema;
use Illuminate\Http\Request;

class TemasApiController extends Controller
{

    public function list($idMateria)
    {
        return response()->json(Tema::list($idMateria));
    }

    /**
     * funcion para agregar temas
     * 
     */
    public function addBatch($idMateria, Request $request)
    {
        $temas = Tema::create($idMateria, $request->temas);

        return response()->json($temas, 201);
    }


}
