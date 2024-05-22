<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class ClasesException extends NotifiableException {    
    public static function sinClase() {
        return new self('Clase no encontrada', 404);
    }

    public static function yaAgendada() {
        return new self('Esta clase ya se encuentra agendada', 400);
    }
}