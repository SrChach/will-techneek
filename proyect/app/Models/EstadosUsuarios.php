<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosUsuarios extends Model
{
    use HasFactory;

    public const ACTIVO = 1;
    public const VERIFICAR_DATOS = 2;
    public const VERIFICAR_CORREO = 3;
    public const SUSPENDIDO = 4;

    public const DEFAULT_STATUS = self::VERIFICAR_CORREO;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estados_usuarios';
}
