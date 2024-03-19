<?php

namespace App\Http\Controllers;

use App\Models\Clases;
use App\Models\Materias;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Routing\Router;

class ItemController extends Controller
{

    public function setWin()
    {
        $idRol = Auth::user()->idRol;

        switch ($idRol) {
            case Roles::ADMINISTRADOR: //!administrador
                $win = [
                    "estilo" => "col-xl-3 col-md-3",
                    "wins" => [
                        [
                            'titulo' => 'Alumnos',
                            'icon' => 'text-primary fas fa-user-graduate',
                            'conteo' => User::countUsuariosForRol(3),
                        ],
                        [
                            'titulo' => 'Clases Impartidas',
                            'icon' => 'text-pink fas fa-book',
                            'conteo' => Clases::countClases(4)
                        ],
                        [
                            'titulo' => 'Clases Programadas',
                            'icon' => 'text-warning fas fa-clipboard-check',
                            'conteo' => Clases::countClases(2),
                        ],
                        [
                            'titulo' => 'Profesores',
                            'icon' => 'text-purple fas fa-users',
                            'conteo' => User::countUsuariosForRol(2),
                        ]
                    ]

                ];
                break;
            case Roles::PROFESOR: //! profesor
                $win = [
                    "estilo" => "col-xl-4 col-md-4",
                    "wins" => [
                        [
                            'titulo' => 'Alumnos',
                            'icon' => 'text-primary fas fa-user-graduate',
                            'conteo' => 5,
                        ],
                        [
                            'titulo' => 'Clases Impartidas',
                            'icon' => 'text-pink fas fa-book',
                            'conteo' => Clases::clasesCountForUsuario(Auth::user()->id, 4),
                        ],
                        [
                            'titulo' => 'Clases Programadas',
                            'icon' => 'text-warning fas fa-clipboard-check',
                            'conteo' => Clases::clasesCountForUsuario(Auth::user()->id, 2),
                        ]
                    ]

                ];
                break;
            case Roles::ALUMNO: //!alumno
                $win = [
                    "estilo" => "col-xl-4 col-md-4",
                    "wins" => [
                        [
                            'titulo' => 'Clases Por Programar',
                            'icon' => 'text-primary fas fa-user-graduate',
                            'conteo' => Clases::clasesCountForAlumno(Auth::user()->id, 1),
                        ],
                        [
                            'titulo' => 'Clases Programadas',
                            'icon' => 'text-pink fas fa-book',
                            'conteo' => Clases::clasesCountForAlumno(Auth::user()->id, 2),
                        ],
                        [
                            'titulo' => 'Clases Tomadas',
                            'icon' => 'text-pink fas fa-book',
                            'conteo' => Clases::clasesCountForAlumno(Auth::user()->id, 4),
                        ]
                    ]

                ];
                break;
            default:
                # code...
                break;
        }

        return $win;
    }

    public function setNav()
    {

        $nav = array(
            [
                'titulo' => 'Dashboard',
                'icon' => 'mdi mdi-view-dashboard-outline',
                'ruta' => env('APP_URL'),
                "idRol" => 1
            ],
            [
                'titulo' => 'Materias',
                'icon' => 'mdi mdi-book-education-outline',
                'ruta' => env('APP_URL'). "/materia",
                "idRol" => 1
            ],
            [
                'titulo' => 'Clases',
                'icon' => 'mdi mdi-desk-lamp',
                'ruta' => env('APP_URL') . '/clase',
                "idRol" => 1
            ],
            [
                'titulo' => 'Alumnos',
                'icon' => 'fas fa-graduation-cap',
                'ruta' => env('APP_URL') . '/alumno',
                "idRol" => 1
            ],
            [
                'titulo' => 'Profesores',
                'icon' => 'mdi mdi-teach',
                'ruta' => env('APP_URL') .  '/profesor',
                "idRol" => 1
            ],
            [
                'titulo' => 'Dashboard',
                'icon' => 'mdi mdi-view-dashboard-outline',
                'ruta' => env('APP_URL'),
                "idRol" => 2
            ],
            [
                'titulo' => 'Mis clases',
                'icon' => 'mdi mdi-desk-lamp',
                'ruta' => env('APP_URL') . '/clases/profesor/0/4',
                "idRol" => 2
            ],
            [
                'titulo' => 'Alumnos',
                'icon' => 'fas fa-graduation-cap',
                'ruta' => env('APP_URL') . '/alumnos/profesor/index',
                "idRol" => 2
            ],
            [
                'titulo' => 'Dashboard',
                'icon' => 'mdi mdi-view-dashboard-outline',
                'ruta' => env('APP_URL'),
                "idRol" => 3
            ],
            [
                'titulo' => 'Mis clases',
                'icon' => 'mdi mdi-desk-lamp',
                'ruta' => env('APP_URL') .'/clases/alumno/index',
                "idRol" => 3
            ],
            [
                'titulo' => 'Mis Pedidos',
                'icon' => 'mdi mdi-apps',
                'ruta' => env('APP_URL'). '/pedidos',
                "idRol" => 3
            ],
        );

        return $nav;
    }
}
