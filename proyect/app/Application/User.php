<?php

namespace App\Application;

use App\Exceptions\UserException;
use App\Models\EstadosUsuarios;
use App\Models\Roles;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class User
{

    public const DEFAULT_EMPTY_LASTNAME = '';

    public static function create($nombre, $apellidos = self::DEFAULT_EMPTY_LASTNAME, $correo, $password)
    {
        $user = UserModel::create([
            'idRol' => Roles::DEFAULT,
            'idStatus' => EstadosUsuarios::DEFAULT_STATUS,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $correo,
            'password' => Hash::make($password),
        ]);

        return $user;
    }

    public static function getAuthenticated($email, $password) {
        $user = UserModel::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw UserException::invalidAuth();
        }

        return $user;
    }
}
