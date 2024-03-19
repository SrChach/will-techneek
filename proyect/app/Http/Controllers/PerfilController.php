<?php

namespace App\Http\Controllers;

use App\Models\Dias;
use App\Models\Horarios;
use App\Models\Materias;
use App\Models\User;
use App\Models\UsuariosMaterias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{

    /**
     * 
     * funcion donde se visualizan los datos del usuario
     * 
     */
    public function index()
    {

        /**
         * $users = Users::latest()
         *->take(5)
         *->get(); 
         * consulta ultimos 5
         */

        $horarios = Horarios::horarioUsuario(Auth::user()->id);
        $materias = UsuariosMaterias::where('idUsuario', Auth::user()->id)->get();
        $listMaterias = Materias::all();
        $listDias = Dias::all();

        return view('perfil.ficha', [
            "horarios" => $horarios,
            "materias" => $materias,
            "listMaterias" => $listMaterias,
            "listDias" => $listDias
        ]);
    }

    /**
     *
     * funcion para actualizar el avatar 
     *
     */
    function updateAvatar(Request $request)
    {


        $idUsuario = Auth::user()->id;
        $file = $request->file('avatar');
        $url = "../imagenes/avatar/" . Auth::user()->id . "";
        $fileName = time() . "." . $file->extension();
        $urlFinal = $url . "/" . $fileName;
        $urlAvatar = "https://techneektutor.com/imagenes/avatar/" . Auth::user()->id . "/" . $fileName;

        if (!file_exists($url)) {
            if (!mkdir($url, 0777, true)) {
                //die('Fallo al crear las carpetas...');
                //return false;
            } else {
                if (move_uploaded_file($file, $urlFinal)) {
                    //return true;
                } else {
                    //return false;
                }
            }
        } else {
            if (move_uploaded_file($file, $urlFinal)) {
                //return true;
            } else {
                //return false;
            }
        }

        $user = User::find($idUsuario);
        $user->foto = $urlAvatar;
        $user->save();

        return redirect()->route('perfil.index');
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

        $respuesta['estado'] = true;
        $respuesta['mensaje'] = "Contraseña actualizada";

        return response()->json($respuesta);
    }


    /**
     * 
     * funcion donde se añaden las materias en relacion con el usuario
     * 
     */
    public function addMateria(Request $request)
    {
        $idUser = Auth::user()->id;
        $idMateria = $request->idMateria;

        $data = new UsuariosMaterias();
        $data->idUsuario = $idUser;
        $data->idMateria = $idMateria;
        $data->save();

        $respuesta['mensaje'] = "La materia ha sido agregada a tu lista.";

        return response()->json($respuesta);
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

        $delete = UsuariosMaterias::where('idUsuario', $idUser)
            ->where('idMateria', $idMateria)
            ->delete();

        $respuesta['mensaje'] = "La materia ha sido eliminada de tu lista.";

        return response()->json($respuesta);
    }


    /**
     * 
     * funcion donde se añaden los horarios
     * 
     */
    public function addHorario(Request $request)
    {
        $idUsuario = Auth::user()->id;
        $dia = $request->dia;
        $hora = $request->hora;

        $horaInicio = date("H:i:s", strtotime($hora));
        $horaFinal = date('H:i:s', strtotime('+1 hour', strtotime($horaInicio)));

        //? validar si este horario ya existe
        $horario = Horarios::where('idUsuario', $idUsuario)
            ->where('idDias', $dia)
            ->where('hora_inicio', $horaInicio)
            ->first();

        if (isset($horario)) {
            //se ejecuta cuando el horario existe
            $respuesta['estado'] = false;
            $respuesta['mensaje'] = "No se pueden replicar horarios";
        } else {

            //se ejecuta cuando horario no existe
            $data = new Horarios();
            $data->idUsuario = $idUsuario;
            $data->idDias = $dia;
            $data->hora_inicio = $horaInicio;
            $data->hora_final = $horaFinal;
            $data->save();

            $respuesta['estado'] = true;
            $respuesta['mensaje'] = "Horario agregado con exito";
        }

        return response()->json($respuesta);
    }

    /**
     * 
     * funcion donde se eliminan los horarios
     * 
     */
    public function deleteHorrio($id)
    {
        Horarios::find($id)->delete();

        return redirect()->back();
    }
}
