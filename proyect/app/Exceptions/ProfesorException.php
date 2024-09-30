<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class ProfesorException extends NotifiableException {    
    public static function incorrectAssignment() {
        return new self('Profesor no asignado a esa clase', 404);
    }
}