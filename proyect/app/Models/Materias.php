<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Materias extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'materias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'icono',
        'costo',
    ];

    static function materiasForUsuario($idUsuario)  
    {
        $materiasRelacionadas = DB::table('materias')
            ->select('materias.nombre AS materia', 'materias.icono AS icono', 'materias.id AS idMateria')
            ->join('usuarios_materias', 'usuarios_materias.idMateria', '=', 'materias.id')
            ->where('usuarios_materias.idUsuario', $idUsuario)
            ->get();

        return $materiasRelacionadas;
    }

    static function alumnosForMateria($idMateria) 
    {
        $count = DB::table('pedidos')
			->distinct('idAlumno')
            ->where('pedidos.idMateria', $idMateria)
            ->count();
        
        return $count;
    }

    static function getInfoAlumnosForMateria($idMateria) 
    {
        /* $alumnos = DB::table('usuarios_materias')
            ->select('users.id AS idUsuario', 'users.nombre AS nombreUsuario', 'users.apellidos AS apellidosUsuario',
            'users.email AS correoUsuario', 'users.foto AS fotoUsuario')
            ->join('users', 'usuarios_materias.idUsuario', '=', 'users.id')
            ->where('usuarios_materias.idMateria', $idMateria)
            ->where('users.idRol', Roles::ALUMNO)
            ->get(); */

        $alumnos = DB::table('pedidos')
            ->select('users.id AS idUsuario', 'users.nombre AS nombreUsuario', 'users.apellidos AS apellidosUsuario',
            'users.email AS correoUsuario', 'users.foto AS fotoUsuario')
			->distinct()
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->where('pedidos.idMateria', $idMateria)
            ->get();

        return $alumnos;
    }

    static function totalMaterias($idMateria) 
    {
        $total = DB::table('clases')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('pedidos.idMateria', $idMateria)
            ->sum('materias.costo AS total');
        
        return $total;
    }

    static function getMateriasConMasClases() 
    {
        $info = DB::table('clases')
            ->select('materias.id AS idMateria', 'materias.nombre AS nombreMateria')
            ->selectRaw('COUNT(clases.id) AS contador')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->groupBy('materias.id')
            ->orderBy('contador', 'desc')
            ->limit(5)
            ->get();
        
        return $info;
    }

    static function getMateriasForAlumnoWith($idAlumno, $idProfesor)
    {
        $materias = DB::table('clases')
            ->select('materias.id AS idMateria', 'materias.nombre AS nombreMateria', 'materias.icono AS iconoMateria')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('pedidos.idAlumno', $idAlumno)
            ->where('clases.idProfesor', $idProfesor)
            ->distinct()
            ->get();
        
        return $materias;
    }
}
