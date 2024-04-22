<?php

namespace App\Http\Controllers;

use App\Application\Clases\Materia;
use App\Models\EstadosUsuarios;

class MateriasApiController extends Controller
{

    public function index() {
        return response()->json(Materia::list());
    }

    public function deleteme() {
        return response()->json(EstadosUsuarios::DEFAULT_STATUS);
    }

}
