<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ItemController;
use App\Models\Clases;
use App\Models\Horarios;
use App\Models\Materias;
use App\Models\User;
use App\Models\UsuariosMaterias;
use App\Notifications\CalificarAlumno;
use App\Notifications\CalificarProfesor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Support\Facades\Notification;

class DashboardController extends Controller
{
	
	public function index()
    {
		
		//echo getcwd();
        $item = new ItemController();

        $listaWins = $item->setWin();


        switch (Auth::user()->idRol) {
            case '1':
                //dd('admin');
                //!administrador
                $infoMateriasClases = Materias::getMateriasConMasClases();
                $infoProfesoresCases = User::getProfesoresMasClases();
                $infoAlumnosCases = User::getAlumnosMasClases();
				
				
				$fecha_actual = date("Y-m-d");
				$FechaPasada=date("Y-m-d",strtotime($fecha_actual."- 8 days")); 


				$fechaInicio=strtotime($FechaPasada);
				$fechaFin=strtotime($fecha_actual);
				for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
					$Fecha=date("Y-m-d", $i);
					$FechaIndice=date("d-m-Y", $i);
					$SolicitudesAceptarBiometricos=Clases::whereDate('created_at', '=', $Fecha)
					->select('*')
					->count();
					$SolicitudesAceptarBiometricos=json_encode($SolicitudesAceptarBiometricos);
					$SolicitudesAceptarBiometricos=json_decode($SolicitudesAceptarBiometricos);
					$SolicitudesAceptarBiometricos;
					$Registrados[$FechaIndice]=$SolicitudesAceptarBiometricos;
					
				}
				
                $lastClasesProgramadas = Clases::getLastFiveClases();

                $listMaterias = SELF::getArrayProcesadoMaterias($infoMateriasClases);
                $listProfesores = SELF::getArrayProcesadoUsers($infoProfesoresCases);
                $listAlumnos = SELF::getArrayProcesadoUsers($infoAlumnosCases);

                return view('admin.dashboard', [
                    "listaWins" => $listaWins,
                    "listMaterias" => $listMaterias,
                    "listProfesores" => $listProfesores,
                    "listAlumnos" => $listAlumnos,
                    "lastClasesProgramadas" => $lastClasesProgramadas,
					"Registrados"=>$Registrados
                ]);
            break;
            case '2':
                
                $condicion =  'clases.idProfesor';

                $clasesProgramadas = Clases::getLastFiveClasesForUsuario(Auth::user()->id, 2, $condicion);
                $alumnosMasClases = User::getAlumnosMasClasesForProfesor(Auth::user()->id);

                $listAlumnos = SELF::getArrayProcesadoUsers($alumnosMasClases);

				SELF::verficarCorreo();
				SELF::verificarMaterias();
				SELF::verificarHorarios();
				SELF::verficarCalificacionProfesor();

                return view('profesores.dashboard', [
                    "listaWins" => $listaWins,
                    "clasesProgramadas" => $clasesProgramadas,
                    "listAlumnos" => $listAlumnos
                ]);
            break;
            case '3':
                $condicion =  'pedidos.idAlumno';

                $clasesProgramadas = Clases::getLastFiveClasesForUsuario(Auth::user()->id, 2, $condicion);
                $profesores = User::getLastFiveProfesoresForAlumno(Auth::user()->id);
                //print_r($clasesProgramadas);

				SELF::verficarCorreo();
				SELF::verficarCalificacion();

                return view('alumnos.dashboard', [
                    "listaWins" => $listaWins,
                    "clasesProgramadas" => $clasesProgramadas,
                    "profesores" => $profesores
                ]);
            break;
        }
    }

    public function getArrayProcesadoMaterias($infoItems)
    {
        $countClases = Clases::all()->count();
        $listMaterias = array();
		$colors = ["primary", "pink", "info", "warning", "danger"];

		$cont = 0;
        foreach ($infoItems as $estadistica) {
            $porcentaje = round(($estadistica->contador * 100) / $countClases);

            $objeto = [
                "idMateria" => $estadistica->idMateria,
                "nombreMateria" => $estadistica->nombreMateria,
                "porcentaje" => $porcentaje,
                "contador" => $estadistica->contador,
				"color" => $colors[$cont],
            ];

            array_push($listMaterias, $objeto);
			$cont = $cont + 1;
        }

        return $listMaterias;
    }

    public function getArrayProcesadoUsers($infoItems)
    {
        $countClases = Clases::all()->count();
        $listUsers = array();
        $colors = ["primary", "pink", "info", "warning", "danger"];

        $cont = 0;
        foreach ($infoItems as $estadistica) {
            $porcentaje = round(($estadistica->contador * 100) / $countClases);

            $objeto = [
                "idUsuario" => $estadistica->idUsuario,
                "nombreUsuario" => $estadistica->nombreUsuario,
                "apellidos" => $estadistica->apellidos,
                "porcentaje" => $porcentaje,
                "contador" => $estadistica->contador,
                "color" => $colors[$cont],
            ];

            array_push($listUsers, $objeto);
            $cont = $cont + 1;
        }

        return $listUsers;
    }

	public function getClasesForLastEightDays() 
	{
		$now = Carbon::now();
		$date = Carbon::parse($now);
		$arrayEtiquetas = array(); 

		for ($i=1; $i<=8; $i++) { 
			$endDate = $date->subDay(1);
			$format = $endDate->format('Y-m-d');
			//print($format . '<br>');

			array_push($arrayEtiquetas, $format);
		}

		$respuesta['etiquetas'] = $arrayEtiquetas;

		return response()->json($respuesta);

		//echo $date;
	}

	public function cronHora()
    {
		date_default_timezone_set('America/Mexico_City');
		echo getcwd();
		$fecha=date("Y-m-d H:i");	
		$countClases = Clases::getInfoClaseForCronHora($fecha);
		$countClases=json_encode($countClases, true);
		$countClases=json_decode($countClases, true);
		for($i=0; $i<count($countClases); $i++){
			$id=$countClases[$i]['id'];
			Clases::where('id', $id)
                ->update([
                    'idEstados' => '3'
            ]); 
		}
		
    }
	public function cambioEstadoImpartida()
    {
		date_default_timezone_set('America/Mexico_City');
		//echo getcwd();
		$d = time();
		$fecha=date("Y-m-d H:i:s", strtotime("-1 Hours", $d));
		//echo $fecha;
		//dd($fecha);	
		$countClases = Clases::getInfoClaseForCronHora($fecha);
		/*echo "<pre>";
		print_r($countClases);
		echo "</pre>";*/
		$countClases=json_encode($countClases, true);
		$countClases=json_decode($countClases, true);
		/*echo "<pre>";
		print_r($countClases);
		echo "</pre>";*/
		for($i=0; $i<count($countClases); $i++){
			//echo "entro";
			$id=$countClases[$i]['id'];
			Clases::where('id', $id)
                ->update([
                    'idEstados' => '4'
            ]); 
		}
		
    }
	public function cronAviso()
    {
		date_default_timezone_set('America/Mexico_City');
		$fecha=date("Y-m-d H:i");	
		$countClases = Clases::getInfoClaseForCronAviso($fecha);
		$countClases=json_encode($countClases, true);
		$countClases=json_decode($countClases, true);
		for($i=0; $i<count($countClases); $i++){
			
			$id=$countClases[$i]['id'];
			echo "<pre>";
				print_r($countClases[$i]);
			echo "</pre>";
			 
		}
    }
	
	public function Notificaciones()
    {
		echo "----";
		/*$curl = curl_init();

		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://onesignal.com/api/v1/notifications",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode([
			'app_id' => '17b508e3-8416-45da-bebe-d4667162cf7a',
			'name' => 'string',
			'included_segments' => [
				'string'
			],
			'include_aliases' => [
				'external_id' => [
						'string'
				],
				'onesignal_id' => [
						'string'
				]
			],
			'contents' => [
				'en' => 'English or Any Language Message',
				'es' => 'Spanish Message'
			],
			'send_after' => 'string',
			'delayed_option' => 'last-active',
			'delivery_time_of_day' => 'string',
			'throttle_rate_per_minute' => 0,
			'custom_data' => 'string',
			'external_id' => 'string'
		  ]),
		  CURLOPT_HTTPHEADER => [
			"Authorization: Basic MGEyOWRmYmItMzM1ZS00NzE1LWExNjktNjI2MWI5Mjg5N2Qz",
			"accept: application/json",
			"content-type: application/json"
		  ],
		]); 
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}*/
		
		
		/*function SendOneSignalMessage($message,$empid){
			// Your code here!
			$fields = array(
				'app_id' => '17b508e3-8416-45da-bebe-d4667162cf7a',
				//'include_player_ids' => [$empid], 
				'include_subscription_ids' => array('90dd5371-ffb1-4c82-8ec8-6f92540b9882'),
				'contents' => array("en" =>$message),
				'headings' => array("en"=>"etc"),
				'external_id'=>'defef765-fe28-4d6d-8c3f-2babc3d0f05d',
				'largeIcon' => 'https://cdn4.iconfinder.com/data/icons/iconsimple-logotypes/512/github-512.png',
			);
	
			$fields = json_encode($fields);
			 //print("\nJSON sent:\n");
			 //echo "<pre>";
			//			 print_r($fields);
			//			 echo "</pre>";	
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
												   'Authorization: Basic MGEyOWRmYmItMzM1ZS00NzE1LWExNjktNjI2MWI5Mjg5N2Qz'));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			
			$response = curl_exec($ch);

			echo "<pre>";
			 print_r($response);
			 echo "</pre>";	
			curl_close($ch);
		}
		SendOneSignalMessage("hola", "");*/
		
		
		$curl = curl_init();

		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://onesignal.com/api/v1/apps/17b508e3-8416-45da-bebe-d4667162cf7a/users",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode([
			'properties' => [
				'tags' => [
						'key' => 'value',
						'foo' => 'bar'
				],
				'language' => 'en',
				'timezone_id' => 'America/Mexico_City',
				'lat' => 90,
				'long' => 135,
				'country' => 'US',
				'first_active' => 1678215680,
				'last_active' => 1678215682
			],
			'identity' => [
				'external_id' => '9'
			]
		  ]),
		  CURLOPT_HTTPHEADER => [
			"accept: application/json",
			"content-type: application/json",
			'Authorization: Basic MGEyOWRmYmItMzM1ZS00NzE1LWExNjktNjI2MWI5Mjg5N2Qz'
		  ],
		]);
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			echo "<pre>***";
			$response=json_decode($response, true);
			$response=json_encode($response, true);
			
		  print_r($response);
		  echo "</pre>";
		}
		
		


		/*$curl = curl_init();
		
		curl_setopt_array($curl, [
		  CURLOPT_URL => "https://onesignal.com/api/v1/apps/17b508e3-8416-45da-bebe-d4667162cf7a/users/by/alias_label/alias_id",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => [
				"accept: application/json",
				"content-type: application/json",
				'Authorization: Basic MGEyOWRmYmItMzM1ZS00NzE1LWExNjktNjI2MWI5Mjg5N2Qz'
		  ],
		]);
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		
		curl_close($curl);
		
		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  echo $response;
		}*/
				
		
    }

	public function verficarCorreo()  
	{
		if (Auth::user()->idGoogle == null || Auth::user()->idGoogle === NULL) {
			$mensaje = "Para continuar con el proceso verifica tu correo.";
			app(OneSignalAlertController::class)->getDevicesForUser($mensaje, Auth::user()->id); 
		}
	}

	public function verificarMaterias()  
	{
		$usuario_materia = UsuariosMaterias::where('idUsuario', Auth::user()->id)->get();

		if (count($usuario_materia) == 0) {
			//! no tiene materias registradas
			$mensaje = "Registra tus materias y horarios disponibles.";
			app(OneSignalAlertController::class)->getDevicesForUser($mensaje, Auth::user()->id); 
		}

	}

	public function verificarHorarios()  
	{
		$horarios = Horarios::where('idUsuario', Auth::user()->id)->get();

		if (count($horarios) == 0) {
			//! no tiene materias registradas
			$mensaje = "Registra tus horarios disponibles para que puedas recibir alumnos.";
			app(OneSignalAlertController::class)->getDevicesForUser($mensaje, Auth::user()->id); 
		}
	}

	public function verficarCalificacion()  
	{
		$idUsuario = Auth::user()->id;
		$alumno = User::where('id', Auth::id())->first();

		$clases = Clases::select('clases.id AS idClase', 'materias.nombre AS nombreMateria', 'users.nombre AS nombreProfesor')
			->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
			->join('materias', 'pedidos.idMateria', '=', 'materias.id')
			->join('bitacoras_profesors', 'clases.id', '=', 'bitacoras_profesors.idClase')
			->join('users', 'clases.idProfesor', '=', 'users.id')
			->where('pedidos.idAlumno', $idUsuario)
			->where('bitacoras_profesors.calificacion', '=', '0.0')
			->get();

		foreach ($clases as $clase) {
			$mensaje = "¿Cómo estuvo tu clase de " . $clase->nombreMateria . "? No olvides calificar a tu profesor " . $clase->nombreProfesor;
			app(OneSignalAlertController::class)->getDevicesForUser($mensaje, Auth::user()->id); 
			Notification::send($alumno, new CalificarProfesor($clase->idClase));
		}
		
	}

	public function verficarCalificacionProfesor()  
	{
		$idUsuario = Auth::user()->id;
		$profesor = User::where('id', Auth::id())->first();

		$clases = Clases::select('clases.id AS idClase', 'materias.nombre AS nombreMateria', 'users.nombre AS nombreAlumno')
			->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
			->join('users', 'pedidos.idAlumno', '=', 'users.id')
			->join('materias', 'pedidos.idMateria', '=', 'materias.id')
			->join('bitacoras_alumnos', 'clases.id', '=', 'bitacoras_alumnos.idClase')
			->where('clases.idProfesor', $idUsuario)
			->where('bitacoras_alumnos.calificacion', '=', '0.0')
			->get();

		foreach ($clases as $clase) {
			$mensaje = "No olvides llenar la bitácora de clase número " . $clase->idClase . " y calificar al alumno " . $clase->nombreAlumno . ".";
			app(OneSignalAlertController::class)->getDevicesForUser($mensaje, Auth::user()->id); 
			Notification::send($profesor, new CalificarAlumno($clase->idClase));
		}
		
	}

}
