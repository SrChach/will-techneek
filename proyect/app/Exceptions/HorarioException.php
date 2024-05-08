<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class HorarioException extends NotifiableException {
    public static function existentHorario() {
        return new self('Ese horario ya se encuentra ocupado', 400);
    }
    
    public static function notFound() {
        return new self('Ese horario no existe', 400);
    }
}