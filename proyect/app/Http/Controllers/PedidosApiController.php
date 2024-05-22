<?php

namespace App\Http\Controllers;

use App\Application\Clases\Clase;
use App\Application\Clases\Materia;
use App\Application\Clases\Pedido;
use App\Exceptions\MateriasException;
use App\Exceptions\PedidosException;
use App\Helpers\FechaManager;
use App\Mail\CrearPedidoAlumnoMailer;
use App\Mail\PagoPedidoAlumnoMailer;
use App\Models\Clases;
use App\Models\EstadosPagos;
use App\Models\Materias;
use App\Models\Pedidos;
use App\Models\User;
use App\Notifications\PedidoEstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redis;

use App\Models\Roles;
use App\Models\UsuariosMaterias;

class PedidosApiController extends Controller
{

    public function index() {
        $pedidos = Pedido::list();

        return response()->json($pedidos);
    }

    public function get($idPedido)
    {
        $pedidos = Pedido::get($idPedido);

        return response()->json($pedidos);
    }

    // TODO add notificaciones a usuarios, mail y admin
    public function store(Request $request)
    {
		$request->validate([
            'idMateria' => 'required',
            'idTema' => 'required'
        ],
        [
            'idMateria.required' => 'Selecciona una materia',
            'idTema.required' => 'El tema es obligatorio'
        ]);

        $idAlumno = Auth::user()->id;
        $materia = Materias::find($request->idMateria);

        if (!$materia) {
            throw MateriasException::invalid();
        }

        $pedido = Pedido::store(
            $idAlumno, $request->idMateria, $request->idTema, $request->numeroHoras, $request->precioTotal
        );

        $pedido->materia = $materia;

        return response()->json($pedido, 201);
    }

    public function show($folio)
    {
        return Pedido::getWithClases($folio);
    }

    /**
     * Resumen de orden. Pendiente multiplicar precio de la orden por horas
     */
    function resumenPedido($folio)
    {
        $infoPedido = Pedido::getByFolio($folio);
        $materia = Materia::getById($infoPedido->idMateria);

        $fechaRegistro = date('d-m-Y');
        $horaRegistro = date('h:m:s');

        $formatoFecha = FechaManager::formatearFecha($fechaRegistro, $horaRegistro);
        $infoMes = FechaManager::mesNombre($formatoFecha['numeroMes']);

        return response()->json([
            "materia" => $materia,
            "folio" => $folio,
            "pedido" => $infoPedido,
            "subtotal" => $materia->costo,
            "formatoFecha" => $formatoFecha,
            "infoMes" => $infoMes,
        ]);
    }


    /**
     * Aprueba el pago. Genera clases vacías por asignar
     */
    public function pedidoPagado(Request $request, $folio)
    {
        $request->validate([
            'horas' => 'required|numeric|gt:0',
            'total' => 'required|numeric|gt:0'
        ],
        [
            'horas' => 'Especifica las horas solicitadas',
            'total' => 'El total es obligatorio y debe ser un numero positivo'
        ]);

        $pedido = Pedido::markAsPaid($folio, $request->horas, $request->total);

        if (Clase::countByPedido($pedido->id) > 0) {
            throw PedidosException::alreadyHasClasses();
        }

        Clase::createBatch($request->horas, $pedido->id);
        return response()->json([
            'pedido' => $pedido,
            'clases' => Clase::getByPedido($pedido->id)
        ]);
    }

    /**
     * Controlador respuesta mercado Pago
     */
    public function feedback($folio)
    {
        // TODO mejorar logica PedidosController::feedback
    }

}
