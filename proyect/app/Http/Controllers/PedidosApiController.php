<?php

namespace App\Http\Controllers;

use App\Application\Clases\Pedido;
use App\Exceptions\MateriasException;
use App\Models\Materias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidosApiController extends Controller
{

    public function index() {
        $pedidos = Pedido::list();

        return response()->json($pedidos);
    }

    public function get()
    {
        $idAlumno = Auth::user()->id;
        $pedidos = Pedido::get($idAlumno);

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

        return response()->json($pedido, 201);
    }

}
