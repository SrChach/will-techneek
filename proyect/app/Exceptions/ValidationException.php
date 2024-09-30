<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class ValidationException extends NotifiableException {
    public static function invalidParameter($strParam) {
        return new self("Parametro invalido: '$strParam'", 422);
    }

    public static function requiredParameter($strParam) {
        return new self("Parametro requerido: '$strParam'", 422);
    }
}