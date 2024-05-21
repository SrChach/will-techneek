<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class UsuariosMaterias extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'usuarios_materias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'idUsuario',
        'idMateria'
    ];

    //! funcion para obtener a los ultimos 5 usuarios asociados con una materia segu el id de la misma y el idRol
    static function getLastUsuariosForMateria($idMateria, $idRol) 
    {
        $usuarios = DB::table('usuarios_materias')
            ->select('users.id AS id_use', 'users.nombre AS nombreUsuario', 'users.apellidos AS apellidosUsuario',
            'users.email AS emailUsuario', 'users.foto AS fotoUsuario')
            ->join('users', 'usuarios_materias.idUsuario', '=', 'users.id')
            ->where('usuarios_materias.idMateria', $idMateria)
            ->where('users.idRol', $idRol)
            ->take(5)
            ->get();
        
        return $usuarios;

    }
}
