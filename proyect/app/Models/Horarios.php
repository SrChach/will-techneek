<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Horarios extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'horarios';

    function usuario(): BelongsTo {
        return $this->belongsTo(User::class, 'idUsuario');
    }

    static function horarioUsuario($idUsuario)
    {
        $horarios = DB::table('horarios')
            ->join('dias', 'horarios.idDias', '=', 'dias.id')
            ->where('idUsuario', $idUsuario)
            ->select('horarios.id AS id', 'dias.nombre AS dia', 'horarios.hora_inicio AS hora_inicio', 'horarios.hora_final AS hora_final')
            ->get();
    
        return $horarios;
    }

    static function horarioMateriaAll($idMateria)
    {

        $horarios = DB::table('users')
            ->where('horarios.id AS idHorario', 'horarios.idDias AS dia', 'horarios.hora_inicio AS hora_inicio',
            'horarios.hora_final AS hora_final')
            ->join('usuarios_materias', 'users.id', '=', 'usuarios_materias.idUsuario')
            ->join('horarios', 'users.id', '=', 'horarios.idUsuario')
            ->where('usuarios_materias.idMateria', $idMateria)
            ->get();

        return $horarios;
    }

    static function horarioMateriaGoup($idMateria){
        $horarios = DB::table('users')
            ->select('horarios.id AS idHorario', 'horarios.idDias AS dia')
            ->join('usuarios_materias', 'users.id', '=', 'usuarios_materias.idUsuario')
            ->join('horarios', 'users.id', '=', 'horarios.idUsuario')
            ->where('usuarios_materias.idMateria', $idMateria)
            ->groupBy('idDias')
            ->get();

        return $horarios;
    }

    static function horariosSegunDia($idDia) 
    {
        $horarios = DB::table('horarios')
            ->where('idDias', $idDia)
            ->groupBy('hora_inicio')
            ->get();

        return $horarios;
    }

    static function getHorariosDiasForMaterias($idMateria) 
    {
        $dias = DB::table('usuarios_materias')
            ->select('horarios.idDias AS numeroDia')
            ->join('horarios', 'usuarios_materias.idUsuario', '=', 'horarios.idUsuario')
            ->where('usuarios_materias.idMateria', $idMateria)
            ->distinct()
            ->get();
        
        return $dias;
    }
    
}
