<?php

namespace App\Application\Clases;

use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\Materias;
use App\Models\Pedidos;

class Materia
{
    public static function list() {
        return Materias::all();
    }

    // TODO refactor
    public static function list_full() {
        $materias = Materias::all();
        $listaMaterias = [];

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

            $listaMaterias[] = $objetoMateria;
        }

        return $listaMaterias;
    }

    // TODO subir imagenes
    public static function create($nombre, $urlIcon, $costo)
    {
        $materia = Materias::create([
            'nombre' => $nombre,
            'icono' => $urlIcon,
            'costo' => $costo
        ]);

        return $materia;
    }
}
