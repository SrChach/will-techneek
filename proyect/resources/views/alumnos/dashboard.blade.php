@extends('layouts.app')

@section('content')
    <!-------------------------------------- Dashboard Alumno  ----------------------------->
    <div class="row">
        <div class="d-flex col-12 align-items-center mb-2">
            <img src="{{ Auth::user()->foto }}" alt="image" class="img-fluid rounded-circle img-thumbnail me-3"
                style="width:120px !important; height:120px !important">
            <h1>Hola {{ Auth::user()->nombre . ' ' . Auth::user()->apellidos }} </h1>
        </div>
    </div>

    @foreach ($listaWins['wins'] as $win)
        <div class="{{ $listaWins['estilo'] }}">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4"> {{ $win['titulo'] }} </h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <i style="font-size: 70px;" class="{{ $win['icon'] }}"></i>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal text-dark" data-plugin="counterup"> {{ $win['conteo'] }} </h2>
                            <a href="{{route('clases.alumno.index')}}" class="text-muted mb-1">Ver mas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    @endforeach

    <div class="row">



        <!-- Calendarios -->
        <div class="col-xl-6 col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Horario</h4>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <!-- Clases programadas -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3"><i class="mdi mdi-notification-clear-all me-1"></i> Clases
                        programadas</h4> <!--las siguientes 6 clases -->

                    <ul class="list-group mb-0 user-list">
                        @foreach ($clasesProgramadas as $claseProgramada)
                            <li class="list-group-item">
                                <a href=" {{ route('ficha.show', [$claseProgramada->idClase, $claseProgramada->idProfesor, Auth::user()->id]) }} "
                                    class="user-list-item">
                                    <div class="user float-start me-3">
                                        <i class="mdi mdi-circle text-primary"></i>
                                    </div>
                                    <div class="user-desc overflow-hidden">
                                        <h5 class="name mt-0 mb-1"> {{ $claseProgramada->nombreMateria }} -
                                            {{ $claseProgramada->nombreUsuario }} </h5>
                                        <span class="desc text-muted font-12 text-truncate d-block">
                                        	<?php
                                            //echo $clase->fecha;
                                            $fecha=explode("-", $claseProgramada->fechaClase);
											//print_r($fecha);
											$nuevaFecha=$fecha['2']."-".$fecha['1']."-".$fecha['0'];
											$Hora=substr($claseProgramada->horaClase, 0, 5);
											?>
                                            {{ $nuevaFecha . ' ' .$Hora }}
                                            
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Tus profesores -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Mis profesores</h4>

                    <ul class="list-group mb-0 user-list">
                        @foreach ($profesores as $profesor)
                            <li class="list-group-item">
                                <a href=" {{ route('profesor.alumno.ficha', $profesor->idUser) }} " class="user-list-item">
                                    <div class="user avatar-sm float-start me-2">
                                        <img src=" {{ $profesor->foto }} " alt="" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="user-desc">
                                        <h5 class="name mt-0 mb-1"> {{ $profesor->nombre . ' ' . $profesor->apellidos }}
                                        </h5>
                                        <p class="desc text-muted mb-0 font-12"> {{ $profesor->correo }} </p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>


    </div>

    <!-- Center modal content -->
    <div class="modal fade" id="centermodal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-end">
                            <p id="folioClase"></p>
                        </div>
                        <div class="col-12 text-center">
                            <h4><span id="spanEstado" class="badge rounded-pill"></span></h4>
                        </div>
                        <div class="col-12 text-center">
                            <img id="icon-materia" src="" alt="image"
                                class="img-fluid avatar-md rounded-circle" />
                            <p id="nombreMateria"></p>
                        </div>
                        <div class="col-6 text-center">
                            <img id="icon-profesor" src="" alt="image"
                                class="img-fluid avatar-md rounded-circle" />
                            <p id="nombreProfesor"></p>
                        </div>
                        <div class="col-6 text-center">
                            <img id="icon-alumno" src="" alt="image"
                                class="img-fluid avatar-md rounded-circle" />
                            <p id="nombreAlumno"></p>
                        </div>
                        <div class="col-12 text-center">
                            <a id="detallesClase" href="#" class="btn btn-info rounded-pill waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-alert-circle-outline"></i></span>Detalles
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let idSujeto = '{{ Auth::user()->id }}';
            let ruta = 'https://techneektutor.com/sistema/calendario/alumno/' + idSujeto + '/2';
            console.log(ruta);
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,basicWeek,basicDay',
                },
                locale: 'es',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                    'Septiembre',
                    'Octubre', 'Noviembre', 'Diciembre'
                ],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
                    'Nov', 'Dic'
                ],
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                events: {
                    url: ruta,
                    displayEventTime: true,
                    eventTimeFormat: { // like '14:30:00'
                                            hour: '2-digit',
                                            minute: '2-digit',
                                            second: false,
                                            hour12: false,
                                          }
                },
                eventClick: function(info) {
                    let idClase = info.event.id;
                    $.ajax({
                        type: "GET",
                        url: "https://techneektutor.com/sistema/calendario/admin/" + idClase,
                        datatype: "json",
                        success: function(data) {
                            console.log(data);
                            let ruta = 'https://techneektutor.com/sistema/clases/ficha/alumno/' +
                                data.idClase;

                            $("#spanEstado").removeClass();
                            $('#centermodal').modal('show');
                            $("#icon-materia").attr("src", data.icono);
                            $("#icon-alumno").attr("src", data.avatarAlumno);
                            $("#icon-profesor").attr("src", data.avatarProfesor);
                            $('#folioClase').html('<b>Folio: </b>' + data.idClase);
                            $('#nombreMateria').html('<b>Materia: </b>' + data
                                .nombreMateria + '<br> ' + data.diaMes + ' ' + data.nombreMes + ' ' + data.year
                                + '<br> ' + data.horaCeros + ':00 ' + data.horaAtrr);
                            $('#nombreProfesor').html('<b>Profesor: </b>' + data
                                .nombreProfesor);
                            $('#nombreAlumno').html('<b>Alumno: </b>' + data.nombreAlumno);
                            $('#detallesClase').attr('href', ruta);
                            $('#spanEstado').addClass('badge rounded-pill bg-' + data
                                .etiqueta)
                            $('#spanEstado').html(data.estado);
                        },
                        error: function(error) {
                            console.log(error);
                        },
                    });
                }
            });
            calendar.render();
        });
    </script>
@endsection
