<?php

namespace App\Application\Clases;

use App\Models\Materias;

class Materia
{
    public static function list() {
        return Materias::all();
    }
}
