<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class PedidosException extends NotifiableException {
    public static function alreadyHasClasses() {
        return new self('El pedido ya tiene clases existentes', 400);
    }

    public static function sinPedidos() {
        return new self('El usuario no cuenta con pedidos', 404);
    }

    public static function notFound() {
        return new self('Pedido no encontrado', 404);
    }
}