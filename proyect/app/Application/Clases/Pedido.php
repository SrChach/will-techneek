<?php

namespace App\Application\Clases;

use App\Models\Pedidos;

class Pedido
{
    
    public static function list() {
        $pedidos = Pedidos::all();
        return $pedidos;
    }

    public static function get($alumnoId) {
        $pedidos = Pedidos::pedidosForUsuario($alumnoId);
        return $pedidos;
    }

    public static function store($idAlumno, $idMateria, $idTema, $numero_horas, $precio_total) {
        $pedido = new Pedidos();

        $pedido->folio = 'Pedido_' . time();
        $pedido->idEstadoPago = 1;

        $pedido->idAlumno = $idAlumno;
        $pedido->idMateria = $idMateria;
        $pedido->idTemario = $idTema;
        $pedido->numero_horas = $numero_horas;
        $pedido->total = $precio_total;

        $pedido->save();

        return $pedido;
    }
    
}
