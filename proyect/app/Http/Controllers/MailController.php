<?php

namespace App\Http\Controllers;

use App\Mail\ClaseImpartidaAlumnoMailer;
use App\Mail\ClaseProgramadaAlumnoMailer;
use App\Mail\ClaseProgramadaProfesorMailer;
use App\Mail\CrearPedidoAlumnoMailer;
use App\Mail\PagoPedidoAlumnoMailer;
use App\Models\Materias;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{


    public function envio()
    {

        try {

            //pedido de prueba 229
            //clase de prueba 233

            $idPedido = 229;
            $idClase = 233;
            $mailProfe = "xg8643747@gmail.com"; //correo profe test
            $user = User::find(6);
            $mail = $user->email;

            $correo = new ClaseProgramadaProfesorMailer($idClase, $user);

            $envio = Mail::to($mailProfe)->send($correo);
            dd($envio);  

            
        } catch (\Exception $e) {

            var_dump($e->getMessage());

        }
    }
}
