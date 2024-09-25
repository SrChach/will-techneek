<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class MateriasException extends NotifiableException {
    public static function notCreated() {
        return new self('Materia no creada', 400);
    }

    public static function invalid() {
        return new self('Proporcionaste una materia incorrecta', 400);
    }
    
    public static function notFound() {
        return new self('Esa materia no existe', 404);
    }

    public static function unlinkedUser() {
        return new self('Usuario no relacionado a la materia', 404);
    }

    public static function linkedUser() {
        return new self('Usuario ya relacionado a la materia', 400);
    }
}