<?php

namespace App\Application\Clases;

use App\Models\EstadosPagos;
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

    public static function getByFolio($folio) {
        return Pedidos::where('folio', $folio)->first();
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

    public static function getWithClases($folio) {
        $pedido = self::getByFolio($folio);

        $idPedido = $pedido->id;
        $pedido = Pedidos::infoPedido($folio);
        $clases = Pedidos::clasesForPedido($idPedido);

        return [
            'pedido' => $pedido,
            'clases' => $clases
        ];
    }

    public static function markAsPaid($folio, $horas, $precioTotal) {
        $pedido = Pedidos::where('folio', $folio)->first();

        $pedido->idEstadoPago = EstadosPagos::PAGADO;
        $pedido->numero_horas = $horas;
        $pedido->total = $precioTotal;
        $pedido->save();

        return $pedido;
    }
    
}
