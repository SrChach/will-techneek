<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class MateriasException extends NotifiableException {
    public static function notCreated() {
        return new self('Materia no creada', 400);
    }
}