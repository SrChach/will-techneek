<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Devices extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'devices';

    static function getDevicesForUser($idUser)  
    {
        $devices = DB::table('devices')
            ->select(
                'devices.idOneSignal AS idOneSignal',
                'devices.suscripcionEstado AS suscripcionEstado',
                'devices.tokenOneSignal AS tokenOneSignal',
            )
            ->join('users', 'devices.idUsuarios', '=', 'users.id')
            ->where('devices.idUsuarios', $idUser)
            ->get();
        
        return $devices;
    }
}
