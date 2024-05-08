<?php

namespace App\Application\Clases;

use App\Models\Clases;
use App\Models\EstadosClases;
use App\Models\EstadosPagos;

class Clase
{

    /**
     * TODO priorizar id de pedido
     * NOTA: numeroClases = clase por hora
     */
    static function createBatch($numeroClases, $idPedido) {
        for ($i = 0; $i < $numeroClases; $i++) {
            $clase = new Clases();
            $clase->idPedido = $idPedido;
            $clase->idEstados = EstadosClases::DEFAULT;

            $clase->save();
        }
    }

    static function getByPedido($idPedido) {
        return Clases::where('idPedido', $idPedido)->get();
    }
    
    static function countByPedido($idPedido) {
        return Clases::where('idPedido', $idPedido)->count();
    }

}