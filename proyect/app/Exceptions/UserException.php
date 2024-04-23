<?php

namespace App\Exceptions;

use \App\Exceptions\NotifiableException;

class UserException extends NotifiableException {
    public static function invalidAuth() {
        return new self('Invalid user or password', 401);
    }
}