<?php

namespace App\Models;

use App\Exceptions\ValidationException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    const ADMINISTRADOR = 1;
    const PROFESOR = 2;
    const ALUMNO = 3;
    const DEFAULT = self::ALUMNO;

    const ROLE_STRING_MAP = [
        'administrador' => self::ADMINISTRADOR,
        'profesor' => self::PROFESOR,
        'alumno' => self::ALUMNO
    ];

    public static function getRole($strRole) {
        $role = self::ROLE_STRING_MAP[$strRole] ?? null;

        if (!$role) {
            throw ValidationException::invalidParameter($strRole);
        }

        return $role;
    }

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
}
