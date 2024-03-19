<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    static function countUsuariosForRol($idRol)
    {
        $count = DB::table('users')
            ->where('idRol', $idRol)
            ->count();

        return $count;
    }

    static function horariosForUsers($idDias, $hora_inicio)
    {
        $users = DB::table('users')
            ->select(
                'users.id AS idUsuario',
                'users.nombre AS nombre',
                'users.apellidos AS apellidos',
                'users.email AS correo',
                'users.foto AS foto',
                'users.puntuacion AS puntuacion'
            )
            ->leftJoin('horarios', 'users.id', '=', 'horarios.idUsuario')
            ->where('idDias', $idDias)
            ->where('hora_inicio', $hora_inicio)
            ->groupBy('idUsuario')
            ->get();

        return $users;
    }

    static function getAlumnosForProfesor($idProfesor)
    {
        $alumnos = DB::table('clases')
            ->select(
                'users.id AS idUser',
                'users.nombre AS nombre',
                'users.apellidos AS apellidos',
                'users.email AS correo',
                'users.foto AS foto'
            )
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->where('clases.idProfesor', $idProfesor)
            ->where('users.idRol', Roles::ALUMNO)
            ->distinct()
            ->get();

        return $alumnos;
    }

    static function getProfesoresMasClases()
    {
        $info = DB::table('clases')
            ->select('users.id AS idUsuario', 'users.nombre AS nombreUsuario', 'users.apellidos AS apellidos')
            ->selectRaw('COUNT(clases.id) AS contador')
            ->join('users', 'clases.idProfesor', '=', 'users.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->groupBy('clases.idProfesor')
            ->orderBy('contador', 'desc')
            ->limit(5)
            ->get();

        return $info;
    }


    static function getAlumnosMasClases()
    {
        $info = DB::table('clases')
            ->select('users.id AS idUsuario', 'users.nombre AS nombreUsuario', 'users.apellidos AS apellidos')
            ->selectRaw('COUNT(clases.id) AS contador')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->groupBy('pedidos.idAlumno')
            ->orderBy('contador', 'desc')
            ->limit(5)
            ->get();

        return $info;
    }

    static function getAlumnosMasClasesForProfesor($idProfesor)
    {
        $info = DB::table('clases')
            ->select('users.id AS idUsuario', 'users.nombre AS nombreUsuario', 'users.apellidos AS apellidos')
            ->selectRaw('COUNT(clases.id) AS contador')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('clases.idProfesor', $idProfesor)
            ->groupBy('pedidos.idAlumno')
            ->orderBy('contador', 'desc')
            ->limit(5)
            ->get();

        return $info;
    }

    static function getLastFiveProfesoresForAlumno($idAlumno)
    {
        $alumnos = DB::table('clases')
            ->select(
                'users.id AS idUser',
                'users.nombre AS nombre',
                'users.apellidos AS apellidos',
                'users.email AS correo',
                'users.foto AS foto'
            )
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'clases.idProfesor', '=', 'users.id')
            ->where('pedidos.idAlumno', $idAlumno)
            ->distinct()
            ->limit(5)
            ->get();

        return $alumnos;
    }

    static function getClasesForAlumnoWithProfesor($idAlumno, $idProfesor, $idEstado)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno',
                'materias.nombre AS nombreMateria',
                'materias.icono AS iconoMateria',
                'materias.id AS idMateria',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'clases.meeets AS link',
            )
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('pedidos.idAlumno', $idAlumno)
            ->where('clases.idProfesor', $idProfesor)
            ->where('clases.idEstados', $idEstado)
            ->get();

        return $clases;
    }

    static function getClasesCalendarForUsuario($id, $condicion)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'estados_clases.color AS colorEstado',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'users.nombre AS nombreAlumno',
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->whereBetween('clases.idEstados', [EstadosClases::PROGRAMADA, EstadosClases::PAGADA])
            ->where($condicion, $id)
            ->get();

        return $clases;
    }

    static function getClaseCalendarForUsuario($idClase, $idSujeto, $condicion)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'materias.id AS idMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->whereBetween('clases.id', $idClase)
            ->where($condicion, $idSujeto)
            ->get();

        return $clases;
    }
}
