<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Materias;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    
    /**
     * TODO: esto se debe pasar a un nuevo proyecto
     */
    //!!! Metodos API
    
    public function getMateria($idMateria)  
    {
        $materia = Materias::find($idMateria);

        return response()->json($materia);
    }

}
