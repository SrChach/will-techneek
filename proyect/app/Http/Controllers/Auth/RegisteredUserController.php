<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OneSignalAlertController;
use App\Models\EstadosUsuarios;
use App\Models\Materias;
use App\Models\Roles;
use App\Models\User;
use App\Models\UsuariosMaterias;
use App\Notifications\RegistroAlumno;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use DB;
use Illuminate\Support\Facades\Notification;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $listamaterias = Materias::all();
        return view('auth.register', [
            "listmaterias" => $listamaterias
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $listaMaterias = $request->materias;

        $user = User::create([
            'idRol' => Roles::ALUMNO,
            'idStatus' => EstadosUsuarios::VERIFICAR_CORREO,
            'nombre' => $request->nombre,
            'apellidos' => $request->apellidos,
            'email' => $request->correo,
            'password' => Hash::make($request->contraseña),
        ]);

        SELF::enviarAlerta($request->nombre, $request->apellidos);    

        event(new Registered($user));

        Auth::login($user); 

        $respuesta['estado'] = true;
        $respuesta['mensaje'] = "Registro exitoso";

        $this->addmateriausuario($listaMaterias);   

        return response()->json($respuesta);
    }

	public function verificarCorreo(Request $request)
    {
        
		$CorreoVerificar=$_GET['CorreoVerificar'];
		$users = DB::table('users')->where('email', $CorreoVerificar)->get();
		$users=json_encode($users, true);
		$users=json_decode($users, true);
		if($users){
			echo "Existe";
		}
		else{
		}
    }


    public function addmateriausuario($materias)
    {
        $dataMaterias = array();

        for ($i = 0; $i < sizeof($materias); $i++) {

            $data = [
                'idUsuario' => Auth::user()->id,
                'idMateria' => $materias[$i]
            ];

            array_push($dataMaterias, $data);

            $data = [];
        }

        UsuariosMaterias::insert($dataMaterias);
    }

    public function enviarAlerta($nombre, $apellidos)  
    {
        $user = User::where('idRol', 1)->first();
        Notification::send($user, new RegistroAlumno($nombre, $apellidos));

        $mensaje = "Se ha registrado un nuevo alumno con éxito " . $nombre . " " . $apellidos;
        app(OneSignalAlertController::class)->getDevicesForUser($mensaje, $user->id); 
    }
}
