<?php

namespace App\Http\Controllers;

use App\Models\Temas;
use Illuminate\Http\Request;

class TemasController extends Controller
{

    /**
     * funcion para listar los temas de una materia
     * 
     */
    public function listar($idMateria)
    {
        
        $listaTemas = Temas::where('idMateria', $idMateria)->get();

        return response()->json($listaTemas);
    }

    /**
     * funcion para agregar temas
     * 
     */
    public function addTema($infoMateria, $listTitulos, $listNumeros)
    {
        //? creacion de array data para insert de tema
        $dataTemas = array();

        for ($i=0; $i < sizeof($listTitulos); $i++) { 

            $data = [
                'idMateria' => $infoMateria->id,
                'numero' => $listNumeros[$i], 
                'nombre' => $listTitulos[$i]
            ];

            array_push($dataTemas, $data);

            $data = [];
        }

        Temas::insert($dataTemas);
    }


}
