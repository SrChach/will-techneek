<?php

namespace App\Application;

use App\Exceptions\UserException;
use App\Models\EstadosUsuarios;
use App\Models\Roles;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class Profesor
{
    public static function create($nombre, $apellidos, $email, $password) {
        $profesor = User::create(
            $nombre, $apellidos, $email, $password,
            Roles::PROFESOR, EstadosUsuarios::VERIFICAR_DATOS
        );

        if(!$profesor) {
            throw UserException::notCreated();
        }

        // TODO add bienvenida profesor
        return $profesor;
    }
}