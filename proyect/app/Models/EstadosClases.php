<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosClases extends Model
{
    use HasFactory;

    const POR_PROGRAMAR = 1;
    const PROGRAMADA = 2;
    const EN_CURSO = 3;
    const IMPARTIDA = 4;
    const PAGO_CLACULADO = 5;
    const PAGADA = 6;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estados_clases';
}
