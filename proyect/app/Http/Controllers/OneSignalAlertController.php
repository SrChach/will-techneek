<?php

namespace App\Http\Controllers;

use App\Models\Devices;
use Illuminate\Http\Request;
use Ladumor\OneSignal\OneSignal;
use Illuminate\Support\Facades\Auth;

class OneSignalAlertController extends Controller
{
    public function alertOneSiganlFirst(Request $request)
    {
        $idUsuario = Auth::user()->id;
        $idOneSignal = $request->idOneSignal;
        $suscripcionEstado = $request->suscripcionEstado;
        $tokenOneSignal = $request->tokenOneSignal;

        $verificacion = Devices::where('idUsuarios', $idUsuario)
            ->where('idOneSignal', $idOneSignal)
            ->first();

        if ($verificacion == null) {
            $devices = new Devices();
            $devices->idUsuarios = $idUsuario;
            $devices->idOneSignal = $idOneSignal;
            $devices->suscripcionEstado = $suscripcionEstado;
            $devices->tokenOneSignal = $tokenOneSignal;
            $devices->save();

            $respuesta['mensaje'] = "Device guardado con exito";
        } else {
            $device = Devices::find($verificacion->id);
            $device->suscripcionEstado = $suscripcionEstado;
            $device->save();

            $respuesta['mensaje'] = "Device guardado con exito";
        }

        return response()->json($respuesta);
    }

    public function getDevicesForUser($message, $idUsuario)
    {
        $devices = Devices::getDevicesForUser($idUsuario);

        if (count($devices) == 0) {
            //echo 'no hay devices'; 
        } else {
            $listDevices = array();
 
            foreach ($devices as $device) {
                array_push($listDevices, $device->idOneSignal);
            }

            SELF::sendEnviarOneSignal($message, $listDevices); 
        } 
    }

    public function sendEnviarOneSignal($message, $listDevices)
    {
        $content = array(
            "en" => $message
        );

        //['882d8bd3-20c0-4606-8419-968b5089b629', '477372f7-efa3-4eb0-a23d-f7a935b999cd']
        $fields = array(
            'app_id' => "17b508e3-8416-45da-bebe-d4667162cf7a",
            'include_player_ids' => $listDevices,
            'data' => array("foo" => "bar"),
            'large_icon' => "ic_launcher_round.png", 
            'contents' => $content,
            'url' => "https://techneektutor.com/sistema/" 
        );

        $fields = json_encode($fields);
        // print("\nJSON sent:\n");
        // print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic MGEyOWRmYmItMzM1ZS00NzE1LWExNjktNjI2MWI5Mjg5N2Qz'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        //dd($response);
    }
}
