<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clases extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idPedido'
    ];

    static public function infoClasesAll()
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'clases.pagoProfesor AS pago',
                'estados_clases.id AS idEstado',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'estados_clases.color AS colorEstado',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->orderBy('clases.id', 'desc')
            ->get();

        return $clases;
    }

    static function clasesCountForUsuario($idProfesor, $idEstado)
    {
        $clases = DB::table('clases')
            ->where('idProfesor', $idProfesor)
            ->where('idEstados', $idEstado)
            ->count();

        return $clases;
    }

    static function clasesCountForAlumno($idAlumno, $idEstado)
    {
        $clases = DB::table('clases')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->where('idAlumno', $idAlumno)
            ->where('idEstados', $idEstado)
            ->count();

        return $clases;
    }

    //! esta consulta obtiene la informacion segun el usuario, estado de clases y id sea materia, alumno o profesor
    static function clasesInfoForUsuario($condicion, $id, $idEstado)
    {
        $clases = DB::table('clases')
            ->select(
                'materias.nombre AS nombreMateria',
                'users.nombre AS nombreAlumno',
                'clases.id AS idClase',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno',
                'clases.fecha AS fecha',
                'clases.hora AS hora'
            )
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where($condicion, $id)
            ->where('idEstados', $idEstado)
            ->take(5)
            ->get();

        return $clases;
    }

    static function countClases($idEstadoClase)
    {
        $count = DB::table('clases')
            ->where('idEstados', $idEstadoClase)
            ->count();

        return $count;
    }

    static function getClaseForHoraAndFecha($fecha, $hora)
    {
        $clases = DB::table('clases')
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->first();

        return $clases;
    }

    static function getFichaClase($idClase)
    {
        $clase = DB::table('clases')
            ->select(
                'users.nombre AS nombre',
                'users.foto AS foto',
                'materias.nombre AS materiaNombre',
                'materias.icono AS iconoMateria',
                'materias.costo AS costoMateria',
                'clases.id AS idClase',
                'clases.hora AS hora',
                'clases.fecha AS fecha',
                'clases.meeets AS meets',
                'clases.pagoProfesor AS pagoProfesor',
                'clases.idEstados AS estadoClase',
                'temas.nombre AS temaNombre'
            )
            ->join('users', 'clases.idProfesor', '=', 'users.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->join('temas', 'pedidos.idTemario', '=', 'temas.id')
            ->where('clases.id', $idClase)
            ->first();

        return $clase;
    }

    //info clase for profesor mail
    static function getFichaClaseForMailProfesor($idClase)
    {
        $clase = DB::table('clases')
            ->select(
                'users.nombre AS nombre',
                'users.foto AS foto',
                'materias.nombre AS materiaNombre',
                'materias.icono AS iconoMateria',
                'materias.costo AS costoMateria',
                'clases.id AS idClase',
                'clases.hora AS hora',
                'clases.fecha AS fecha',
                'clases.meeets AS meets',
                'clases.pagoProfesor AS pagoProfesor',
                'clases.idEstados AS estadoClase',
                'clases.pagoProfesor AS pagoProfesor',
                'temas.nombre AS temaNombre'
            )
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('users', 'pedidos.idAlumno', '=', 'users.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->join('temas', 'pedidos.idTemario', '=', 'temas.id')
            ->where('clases.id', $idClase)
            ->first();

        return $clase;
    }

    static function getClasesForMateriaCount($idMateria, $idEstado)
    {
        $count = DB::table('clases')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->where('pedidos.idMateria', $idMateria)
            ->where('clases.idEstados', $idEstado)
            ->count('clases.id');

        return $count;
    }

    //! obtiene el contador de clases segun su estado en relacion con una materia y un id Alumno
    static function getCountClasesForMateriaAndUsuario($idMateria, $idEstadoClase, $idUsuario)
    {
        $count = DB::table('usuarios_materias')
            ->join('pedidos', 'usuarios_materias.idUsuario', '=', 'pedidos.idAlumno')
            ->join('clases', 'pedidos.id', '=', 'clases.idPedido')
            ->where('usuarios_materias.idMateria', $idMateria)
            ->where('clases.idEstados', $idEstadoClase)
            ->where('usuarios_materias.idUsuario', $idUsuario)
            ->count('clases.id');

        return $count;
    }

    //! obtene el contador de un tipo de clases segun el profesor y alumno
    static function getCountClasesForAlumnosAndProfesor($idAlumno, $idProfesor, $idEstadoClase)
    {
        $count = DB::table('pedidos')
            ->join('clases', 'pedidos.id', '=', 'clases.idPedido')
            ->where('pedidos.idAlumno', $idAlumno)
            ->where('clases.idEstados', $idEstadoClase)
            ->where('clases.idProfesor', $idProfesor)
            ->count('clases.id');

        return $count;
    }

    //! obtiene el contador de un tipo de clases segun su estado en relacion con un profesor y un alumno
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
            ->get();

        return $alumnos;
    }

    static function getTotalCostoMateria($idMateria)
    {
        $total = DB::table('clases')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('pedidos.idMateria', $idMateria)
            ->sum('materias.costo');

        return $total;
    }

    static function getTotalCosto($condicion, $id)
    {
        $total = DB::table('clases')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where($condicion, $id)
            ->sum('materias.costo');

        return $total;
    }

    static function getClasesCondicion($id, $condicion)
    {
        $info = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno',
                'clases.fecha AS fecha',
                'clases.hora AS hora',
                'clases.pagoProfesor AS pagoProfesor',
                'clases.meeets AS ligaMeets',
                'estados_clases.nombre AS nombreEstado',
                'estados_clases.etiqueta AS etiquetaEstados',
                'estados_clases.id AS isEstadoClase',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where($condicion, $id)
            ->get();

        return $info;
    }

    static function getClasesForFiltroAll($estado, $inicioFecha, $finFecha)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'estados_clases.id AS idEstado',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->whereBetween('fecha', [$inicioFecha, $finFecha])
            ->where('idEstados', $estado)
            ->get();

        return $clases;
    }

    static function getClasesForFechaAndCodicion($estado, $inicioFecha, $finFecha, $condicion, $idSujeto)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'clases.pagoProfesor AS pago',
                'clases.meeets AS link',
                'estados_clases.id AS idEstadoClase',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->whereBetween('fecha', [$inicioFecha, $finFecha])
            ->where('idEstados', $estado)
            ->where($condicion, $idSujeto)
            ->get();

        return $clases;
    }

    static function getLastFiveClases()
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno',
                'users.nombre AS nombre',
                'users.apellidos AS apellidos',
                'materias.nombre AS materiaNombre',
                'clases.hora AS hora',
                'clases.fecha AS fecha',
            )
            ->join('users', 'clases.idProfesor', '=', 'users.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('clases.idEstados', 2)
            ->orderBy('clases.hora', 'desc')
            ->limit(5)
            ->get();

        return $clases;
    }

    //!obtiene todas las clases de un alumno (usuario) segun su estado
    //? haer una para clases por programar
    static function getLastAllClasesForUsuario($idSujeto, $idEstado, $condicion)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.idEstados AS idEstados',
                'materias.id AS idMateria',
                'users.id AS idUsuario',
                'materias.nombre AS nombreMateria',
                'users.nombre AS nombreUsuario',
                'users.apellidos AS apellidosUsuario',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'clases.meeets AS meeets',
            )
            ->join('users', 'clases.idProfesor', '=', 'users.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where($condicion, $idSujeto)
            ->where('clases.idEstados', $idEstado)
            ->orderBy('clases.fecha', 'asc')
            ->get();

        return $clases;
    }

    static function getLastAllClasesPorProgramar($idSujeto, $idEstado, $condicion)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.idEstados AS idEstados',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'clases.meeets AS meeets',
            )

            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where($condicion, $idSujeto)
            ->where('clases.idEstados', $idEstado)
            ->orderBy('clases.fecha', 'asc')
            ->get();

        return $clases;
    }

    static function getLastFiveClasesForUsuario($idSujeto, $idEstado, $condicion)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'users.id AS idUsuario',
                'pedidos.idAlumno AS idAlumno',
                'clases.idProfesor AS idProfesor',
                'materias.nombre AS nombreMateria',
                'users.nombre AS nombreUsuario',
                'users.apellidos AS apellidosUsuario',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase'
            )
            ->join('users', 'clases.idProfesor', '=', 'users.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where($condicion, $idSujeto)
            ->where('clases.idEstados', $idEstado)
            ->orderBy('clases.fecha', 'asc')
            ->orderBy('clases.hora', 'asc')
            ->limit(5)
            ->get();

        return $clases;
    }

    static function getClasesForCalendar()
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'estados_clases.id AS idEstado',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'estados_clases.color AS colorEstado',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->orderBy('clases.id', 'asc')
            ->where('clases.idEstados', '>', 1)
            ->get();

        return $clases;
    }

    static function getInfoClaseForCalendar($id)
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.fecha AS fechaClase',
                'clases.hora AS horaClase',
                'estados_clases.id AS idEstado',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'estados_clases.color AS colorEstado',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'materias.icono AS iconoMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('clases.id', $id)
            ->first();

        return $clases;
    }
	
	static function getInfoClaseForCronHora($fecha)
    {
		$fechaExplode=explode(' ',$fecha);
		$hora=explode(":", $fechaExplode[1]);
		$hora1=$hora[0].":00";
		$hora2=$hora[0].":59";
		/*echo "<br>";
		echo $hora1.".---.".$hora2;
		echo "<br>";*/
        $clases = DB::table('clases')
            ->select(
                '*'
            )
            ->where('clases.fecha', $fechaExplode[0])
            ->whereBetween('clases.hora', [$hora1, $hora2])
            ->get();
        return $clases;
    }
	
	static function getInfoClaseForCronAviso($fecha)
    {
		$fechaExplode=explode(' ',$fecha);
		$hora=explode(":", $fechaExplode[1]);
		$hora1=($hora[0]+1).":00";
		$hora2=($hora[0]+1).":59";
        $clases = DB::table('clases')
            ->select(
                '*'
            )
            ->where('clases.fecha', $fechaExplode[0])
            ->whereBetween('clases.hora', [$hora1, $hora2])
            ->get();
			
        return $clases;
    }

    static function getInfoClasesForAlumnoAndProfesor($idProfesor, $idAlumno, $idEstado) 
    {
        $clases = DB::table('clases')
            ->select(
                'clases.id AS idClase',
                'clases.fecha AS fechaClase',
                'clases.meeets AS link',
                'clases.hora AS horaClase',
                'estados_clases.id AS idEstado',
                'estados_clases.nombre AS estado',
                'estados_clases.etiqueta AS etiqueta',
                'estados_clases.color AS colorEstado',
                'materias.id AS idMateria',
                'materias.nombre AS nombreMateria',
                'materias.icono AS iconoMateria',
                'clases.idProfesor AS idProfesor',
                'pedidos.idAlumno AS idAlumno'
            )
            ->join('estados_clases', 'clases.idEstados', '=', 'estados_clases.id')
            ->join('pedidos', 'clases.idPedido', '=', 'pedidos.id')
            ->join('materias', 'pedidos.idMateria', '=', 'materias.id')
            ->where('clases.idProfesor', $idProfesor)
            ->where('pedidos.idAlumno', $idAlumno)
            ->where('clases.idEstados', $idEstado)
            ->get();

        return $clases;
    }
}
