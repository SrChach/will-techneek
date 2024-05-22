<?php

namespace App\Http\Controllers;

use App\Application\Horario;
use App\Exceptions\HorarioException;
use App\Exceptions\PerfilException;
use App\Models\Dias;
use App\Models\Horarios;
use App\Models\Materias;
use App\Models\User;
use App\Models\UsuariosMaterias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilApiController extends Controller
{

    /**
     * 
     * funcion donde se visualizan los datos del usuario
     * 
     */
    public function index()
    {
        $horarios = Horarios::horarioUsuario(Auth::user()->id);
        $materias = UsuariosMaterias::where('idUsuario', Auth::user()->id)->get();
        $listMaterias = Materias::all();
        $listDias = Dias::all();

        return response()->json([
            "horarios" => $horarios,
            "materias" => $materias,
            "listMaterias" => $listMaterias,
            "listDias" => $listDias
        ]);
    }

    /**
     * 
     * funcion donde se actualizan los datos generales del perfil
     * 
     */
    public function updateDatos(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->telefono = $request->telefono;
        $user->nacimiento = $request->nacimiento;
        $user->save();

        //retornar mensaje de ajax que los datos se han actualizado correctamente

        $respuesta['estado'] = true;
        $respuesta['mensaje'] = "Datos actualizados";

        return response()->json($respuesta);
    }

    /**
     * 
     * funcion donde se actualizan la contraseña
     * 
     */
    public function updatePassword(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([ "message" => "Contraseña actualizada" ], 200);
    }


    /**
     * Pendiente validar materias ya existentes
     * 
     */
    public function addMateria(Request $request)
    {
        $idUser = Auth::user()->id;
        $idMateria = $request->idMateria;

        $exists = UsuariosMaterias::where('idUsuario', $idUser)
            ->where('idMateria', $idMateria)
            ->first();

        if ($exists) {
            throw PerfilException::existentMateria();
        }

        $materia = new UsuariosMaterias();
        $materia->idUsuario = $idUser;
        $materia->idMateria = $idMateria;
        $materia->save();

        return response()->json($materia, 201);
    }

    /**
     * 
     * funcion donde se eleminan las materias en relacion con el usuario
     * 
     */
    public function deleteMateria(Request $request)
    {
        $idUser = Auth::user()->id;
        $idMateria = $request->idMateria;

        $toDelete = UsuariosMaterias::where('idUsuario', $idUser)
            ->where('idMateria', $idMateria)
            ->first();
        
        if (!$toDelete) {
            throw PerfilException::cannotDeleteUnexistent();
        }

        $toDelete->delete();
        return response()->json(null, 204);
    }


    /**
     * TODO validacion y creación de horarios en distinto mes, año
     * $request->hora tiene formato 00:00
     * $request->dias es un número del 1 al 7, con 1 = Lunes y 7 = Domingo
     * 
     */
    public function addHorario(Request $request)
    {
        $idUsuario = Auth::user()->id;
        $dia = $request->dia;
        $hora = $request->hora;

        $horario = Horario::addHorario($idUsuario, $dia, $hora);

        return response()->json($horario, 201);
    }

    /**
     * 
     * funcion donde se eliminan los horarios
     * 
     */
    public function deleteHorario(Request $request)
    {
        $idUsuario = Auth::user()->id;
        $dia = $request->dia;

        $horaInicio = date("H:i:s", strtotime($request->hora));
        Horario::deleteHorario($idUsuario, $dia, $horaInicio);

        return response()->json(null, 204);
    }
}
