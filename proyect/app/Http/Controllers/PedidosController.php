<?php

namespace App\Http\Controllers;

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

class PedidosController extends Controller
{

    /**
     * 
     * funcion que se encarga de enlistar los pedidos del alumno
     *
     */
    public function index()
    {
        $idAlumno = Auth::user()->id;
        $pedidos = Pedidos::pedidosForUsuario($idAlumno);

        return view('alumnos.pedidos.listar', [
            "pedidos" => $pedidos
        ]);
    }

    /**
     * 
     * funcion de crear el pedido
     *
     */
    public function store(Request $request)
    {
		
		$request->validate([
                'materia'=>'required',
                'listTemario'=>'required'
           ],[
                'materia.required'=>'Selecciona una materia',
                'listTemario.required'=>'El tema es obligatorio'
            ]);
			
        $folio = 'Pedido_' . time();
        $idMateria = $request->materia[0];
        $idTema = $request->listTemario;
        $horas = $request->horas;
        $subtotal = $request->subtotal;
        $total = $request->total;
        $idAlumno = Auth::user()->id;

        $pedido = new Pedidos();
        $pedido->folio = $folio;
        $pedido->idMateria = $idMateria;
        $pedido->idTemario = $idTema;
        $pedido->idAlumno = $idAlumno;
        $pedido->idEstadoPago = 1;
        $pedido->numero_horas = $horas;
        $pedido->total = $total;
        $pedido->save();

        $materia = Materias::find($idMateria);

        $fechaRegistro = date('d-m-Y');
        $horaRegistro = date('h:m:s');

        $infoPedido = Pedidos::where('folio', $folio)->first();
        $idPedido = $infoPedido->id;

        $mensaje = "Has creado un nuevo pedido";
        $mensajeAdmin = "El pedido " . $folio . " ha sido registrado con " . $horas . " horas."; 

        $usuarioAdmin = User::where('idRol', 1)->first();

        Mail::to(Auth::user()->email)->send(new CrearPedidoAlumnoMailer($idPedido, $idAlumno));
        app(OneSignalAlertController::class)->getDevicesForUser($mensaje, $idAlumno); 
        app(OneSignalAlertController::class)->getDevicesForUser($mensajeAdmin, $usuarioAdmin->id); 

        $formatoFecha = app(FechaController::class)->formatearFecha($fechaRegistro, $horaRegistro);
        $infoMes = app(FechaController::class)->mesNombre($formatoFecha['numeroMes']);

        return view('alumnos.pedidos.resumen1', [
            "materia" => $materia,
            "folio" => $folio,
            "pedido" => $pedido,
            "subtotal" => $subtotal, 
            "formatoFecha" => $formatoFecha,
            "infoMes" => $infoMes,
        ]);
    }

    /**
     * funcion de pagar directamente
     */
    function resumenPedido($folio)
    {
        $infoPedido = Pedidos::where('folio', $folio)->first();
        $idMateria = $infoPedido->idMateria;
        $materia = Materias::find($idMateria);
        $subtotal = $materia->costo;

        $fechaRegistro = date('d-m-Y');
        $horaRegistro = date('h:m:s');

        $formatoFecha = app(FechaController::class)->formatearFecha($fechaRegistro, $horaRegistro);
        $infoMes = app(FechaController::class)->mesNombre($formatoFecha['numeroMes']);

        return view('alumnos.pedidos.resumen1', [
            "materia" => $materia,
            "folio" => $folio,
            "pedido" => $infoPedido,
            "subtotal" => $subtotal, 
            "formatoFecha" => $formatoFecha,
            "infoMes" => $infoMes,
        ]);
    }


    /**
     * 
     * funcion de crear el pedido
     *
     */
    public function updatePedido(Request $request, $folio)
    {
        $horas = $request->horas;
        $total = $request->total;

        $info = Pedidos::where('folio', $folio)->get();
        $pedido = Pedidos::find($info[0]->id);
        $pedido->idEstadoPago = 2;
        $pedido->numero_horas = $horas;
        $pedido->total = $total;
        $pedido->save();

        app(ClasesController::class)->crearClases($horas, $info[0]->id);

        return redirect()->route('pedidos.show', $folio);
    }

    /**
     * 
     * funcion que se encarga de crear pedidos
     * !!!
     */
    public function create()
    {
        $listaMateria = Materias::all();
		//$id=4;
		//$infoProfesores = UsuariosMaterias::getLastUsuariosForMateria($id, Roles::PROFESOR);
		//"infoProfesores"=>$infoProfesores
		
        return view('alumnos.pedidos.create', [
            "listaMateria" => $listaMateria
			
        ]);
    }


    /**
     * 
     * funcion que se encarga de crear pedidos
     *
     */
    public function show($folio)
    {
        $pedido = Pedidos::where('folio', $folio)->first();
        $idPedido = $pedido->id;
        $pedido = Pedidos::infoPedido($folio);
        $clases = Pedidos::clasesForPedido($idPedido);
        //dd($pedido);

        return view('alumnos.pedidos.ficha', [
            "pedido" => $pedido,
            "clases" => $clases
        ]);
    }

    /**
     * respuesta de la ap de mercado pago
     */
    public function feedback($folio)
    {
        //collection_id=1319634573&collection_status=approved&payment_id=1319634573&status=approved&external_reference=null&payment_type=credit_card&merchant_order_id=13474531828&preference_id=1500656698-e106d59d-d808-4b6e-9c04-d6cc747d0c46&site_id=MLM&processing_mode=aggregator&merchant_account_id=null
        $collection_id = $_REQUEST['collection_id'];
        $collection_status = $_REQUEST['collection_status'];
        $payment_id = $_REQUEST['payment_id'];
        $status = $_REQUEST['status'];
        $payment_type = $_REQUEST['payment_type'];

        $pedido = Pedidos::where('folio', $folio)->first();

        if($status == "approved")
        {
            echo 'pago aprovado';

            $pedido->idEstadoPago = 2;
            $pedido->save();

            $horas = $pedido->numero_horas;
            
            $idAlumno = Auth::user()->id;

            $infoPedido = Pedidos::where('folio', $folio)->first();
            $idPedido = $infoPedido->id;

            $mensaje = "Muchas gracias, tu pedido ha sido registrado, ahora por favor agenda tus clases.";
            Mail::to(Auth::user()->email)->send(new PagoPedidoAlumnoMailer($idPedido, $idAlumno));
            app(OneSignalAlertController::class)->getDevicesForUser($mensaje, $idAlumno); 
            app(ClasesController::class)->crearClases($horas, $pedido->id);

            SELF::generarNotificacionPagoAprovado($infoPedido);

            return redirect()->route('pedidos.show', $folio);

        }
        else 
        {
            $pedido->idEstadoPago = 3;
            $pedido->save();

            return redirect()->route('pedidos.index');
        }

       

    }

    
    public function generarNotificacionPagoAprovado($pedido)  
    {
        
        $usuarioAlumno = User::where('id', Auth::id())->first();
        $usuarioAdmin = User::where('idRol', 1)->first();

        Notification::send($usuarioAlumno, new PedidoEstatus($pedido));
        Notification::send($usuarioAdmin, new PedidoEstatus($pedido));

    }
	
	public function profesoresMateria($id)  
    {
        
        

		$infoProfesores = UsuariosMaterias::getLastUsuariosForMateria($id, Roles::PROFESOR);
		/*echo "<pre>";
		print_r($infoProfesores);
		echo "</pre>";*/
        return view('alumnos.pedidos.profesores', [
            "infoProfesores"=>$infoProfesores
			
        ]);

    }
}
