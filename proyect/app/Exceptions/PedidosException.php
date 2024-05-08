<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class PedidosException extends NotifiableException {
    public static function alreadyHasClasses() {
        return new self('El pedido ya tiene clases existentes', 400);
    }
}