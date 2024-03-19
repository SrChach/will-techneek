<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposArchivos extends Model
{
    use HasFactory;

    const TAREA = 1;
    const MATERIAL = 2;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipo_archivos';
}
