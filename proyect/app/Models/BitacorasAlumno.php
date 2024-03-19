<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BitacorasAlumno extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bitacoras_alumnos';

    static function getInfoFichaAlumno($idClase)
    {
        $ficha = DB::table('bitacoras_alumnos')
            ->select(
                'users.id AS idAlumno',
                'users.nombre AS nombreAlumno',
                'users.apellidos AS apellidosAlumno',
                'users.telefono AS telefonoAlumno',
                'users.email AS correoAlumno',
                'users.foto AS fotoAlumno',
                'bitacoras_alumnos.calificacion AS calificacionAlumno',
                'bitacoras_alumnos.comentarios AS comentariosAlumno'
            )
            ->join('users', 'bitacoras_alumnos.idAlumno', '=', 'users.id')
            ->join('clases', 'bitacoras_alumnos.idClase', '=', 'clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('bitacoras_alumnos.idClase', $idClase)
            ->first();

        return $ficha;
    }

    static function avgAlumno($idAlumno)  
    {
        $calificacion = DB::table('bitacoras_alumnos')
            ->selectRaw('AVG(bitacoras_alumnos.calificacion) AS calificacion')
            ->whereRaw('bitacoras_alumnos.calificacion > 0.0')
            ->whereRaw('bitacoras_alumnos.idAlumno = ' . $idAlumno)
            ->first();
        
        return $calificacion;
    }
}
