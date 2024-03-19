<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    const ADMINISTRADOR = 1;
    const PROFESOR = 2;
    const ALUMNO = 3;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'roles';
}
