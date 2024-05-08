<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosPagos extends Model
{
    use HasFactory;

    public const POR_PAGAR = 1;
    public const PAGADO = 2;
    public const PAGO_PENDIENTE = 3;
    public const CANCELADO = 4;

    public const DEFAULT_STATUS = self::POR_PAGAR;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estados_pagos';
}
