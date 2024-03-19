<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Pedidos extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pedidos';

    public function user()  
    {
        return $this->belongsTo(User::class);
    }

    static function infoPedido($folio)
    {
        $info = DB::table('pedidos')
            ->select(
                'materias.id AS idMAteria',
                'materias.nombre AS materia',
                'temas.nombre AS tema',
                'temas.numero AS numero',
                'pedidos.folio AS folio',
                'estados_pagos.nombre AS estadoPago',
                'materias.icono AS icono',
                'estados_pagos.etiqueta AS etiqueta',
                'pedidos.numero_horas AS horas',
                'pedidos.total AS total'
            )
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->join('temas', 'pedidos.idTemario', '=', 'temas.id')
            ->join('estados_pagos', 'pedidos.idEstadoPago', '=', 'estados_pagos.id')
            ->where('pedidos.folio', $folio)
            ->first();

        return $info;
    }

    static function infoPedidoForMail($idPedido)
    {
        $info = DB::table('pedidos')
            ->select(
                'materias.nombre AS materia',
                'temas.nombre AS tema',
                'temas.numero AS numero',
                'pedidos.folio AS folio',
                'estados_pagos.nombre AS estadoPago',
                'materias.icono AS icono',
                'estados_pagos.etiqueta AS etiqueta',
                'pedidos.numero_horas AS horas',
                'pedidos.total AS total'
            )
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->join('temas', 'pedidos.idTemario', '=', 'temas.id')
            ->join('estados_pagos', 'pedidos.idEstadoPago', '=', 'estados_pagos.id')
            ->where('pedidos.id', $idPedido)
            ->first();

        return $info;
    }

    static function clasesForPedido($idPedido)
    {
        $clases = DB::table('clases')
            ->select(
                'pedidos.idAlumno AS idAlumno',
                'clases.id AS id',
                'clases.fecha AS fecha',
                'clases.hora AS hora',
                'clases.idProfesor AS idProfesor',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'estados_clases.id AS idEstado',
                'users.nombre AS nombreProfesor',
                'users.apellidos AS apellidosProfesor',
                'users.id AS idProfesor',
            )
            ->leftjoin('users', 'clases.idProfesor', '=', 'users.id')
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->where('idPedido', $idPedido)
            ->get();

        return $clases;
    }

    static function pedidosForUsuario($idUsuario)
    {
        $pedidos = DB::table('pedidos')
            ->select(
                'materias.nombre AS materia',
                'estados_pagos.nombre AS estado',
                'estados_pagos.id AS idEstados',
                'estados_pagos.etiqueta AS etiqueta',
                'pedidos.folio AS folio',
                'numero_horas AS horas'
            )
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->join('estados_pagos', 'pedidos.idEstadoPago', '=', 'estados_pagos.id')
            ->where('idAlumno', $idUsuario)
            ->orderBy('pedidos.id', 'desc')
            ->get();

        return $pedidos;
    }

    static function getCoutAlumnosForMateria($idMateria)
    {
        $count = DB::table('pedidos')
            ->where('pedidos.idMateria', $idMateria)
            ->distinct()
            ->count();

        return $count;
    }

    static function getAlumnoForClase($idClase)
    {
        $infoAlumno = DB::table('clases')
            ->select(
                'users.nombre AS nombreAlumno',
                'users.apellidos AS apellidoAlumno',
                'users.foto AS fotoAlumno',
                'users.email AS correoAlumno'
            )
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->where('clases.id', $idClase)
            ->first();

        return $infoAlumno;
    }
}
