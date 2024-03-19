<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class UsuariosController extends Controller
{
    
    /**
    * 
    * funcion para suspender a un usuario
    * 
    */
    public function suspender($id)  
    {

        $user = User::find($id);
        $user->idStatus = 4;
        $user->save();
        
        $respuesta['mensaje'] = "Usuario suspendido con exito";

        return response()->json($respuesta);

    }

    /**
    * 
    * funcion para activar a un usuario
    * 
    */
    public function activar($id)  
    {
        $user = User::find($id);
        $user->idStatus = 1;
        $user->save();
        
        $respuesta['mensaje'] = "Usuario activado con exito";

        return response()->json($respuesta);
    }

}
