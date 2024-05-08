<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class PerfilException extends NotifiableException {
    public static function existentMateria() {
        return new self('Esa materia ya existe en el perfil', 400);
    }
    
    public static function cannotDeleteUnexistent() {
        return new self('Esa materia no existe en tu perfil', 404);
    }
}