<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BitacorasProfesor extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bitacoras_profesors';


    static function getInfoFichaProfesor($idClase)
    {
        $ficha = DB::table('bitacoras_profesors')
            ->select(
                'users.id AS idProfesor',
                'users.nombre AS nombreProfesor',
                'users.apellidos AS apellidosProfesor',
                'users.email AS correoProfesor', 
                'users.telefono AS telefonoProfesor',
                'users.foto AS fotoProfesor',
                'bitacoras_profesors.calificacion AS calificacionProfesor',
                'bitacoras_profesors.comentarios AS comentariosProfesor'
            )
            ->join('users', 'bitacoras_profesors.idProfesor', '=', 'users.id')
            ->join('clases', 'bitacoras_profesors.idClase', '=', 'clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->where('bitacoras_profesors.idClase', $idClase)
            ->first();

        return $ficha;
    }

    static function avgProfesor($idProfesor)  
    {
        $calificacion = DB::table('bitacoras_profesors')
            ->selectRaw('AVG(bitacoras_profesors.calificacion) AS calificacion')
            ->whereRaw('bitacoras_profesors.calificacion > 0.0')
            ->whereRaw('bitacoras_profesors.idProfesor = ' . $idProfesor)
            ->first();
        
        return $calificacion;
    }
}
