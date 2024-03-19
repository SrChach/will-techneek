<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{

    /**
     * 
     * funcion para subir la imagen de la materia 
     * 
     */

    public function subirIconMateria($icon)
    {
        $url = '../imagenes/materias/';
        $iconName = 'materia_' . time() . "." . $icon->extension();
        $urlFinal = $url . "" . $iconName;
        $urlMateria = "https://techneektutor.com/imagenes/materias/" . $iconName;

        if (!file_exists($url)) {
            if (!mkdir($url, 0777, true)) {
                //return false;
            } else {
                if (move_uploaded_file($icon, $urlFinal)) {
                    //return true;
                } else {
                    //return false;
                }
            }
        } else {
            if (move_uploaded_file($icon, $urlFinal)) {
                //return true;
            } else {
                //return false;
            }
        }

        return $urlMateria;
    }
}
