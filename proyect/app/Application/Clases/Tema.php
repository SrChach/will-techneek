<?php

namespace App\Application\Clases;

use App\Models\Temas;

class Tema
{
    // TODO manage not found exceptions
    public static function list($idMateria) {
        return Temas::where('idMateria', $idMateria)->get();
    }
    
    // TODO subir imagenes. Manejar posicion de "numero"
    public static function create($idMateria, $temas = [])
    {
        $crear_temas = [];
        for ($i=0; $i < sizeof($temas); $i++) {
            $crear_temas[] = [
                'idMateria' => $idMateria,
                'numero' => $i + 1,
                'nombre' => $temas[$i]
            ];
        }

        $result = Temas::insert($crear_temas);

        return $result;
    }
}
