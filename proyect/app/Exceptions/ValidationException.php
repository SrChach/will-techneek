<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class ValidationException extends NotifiableException {
    public static function invalidParameter($strParam) {
        return new self("Parametro invalido: '$strParam'", 422);
    }
}