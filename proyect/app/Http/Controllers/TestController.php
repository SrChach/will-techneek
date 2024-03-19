<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\ClaseAgendada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TestController extends Controller
{

    public function enviarNotificacion()
    {
        # Ejemplo
        $usuarioAlumno = User::where('id', 6)->first();
        $usuarioProfesor = User::where('id', 14)->first();

        Notification::send($usuarioAlumno, new ClaseAgendada(279));
        Notification::send($usuarioProfesor, new ClaseAgendada(279));
    }

}
