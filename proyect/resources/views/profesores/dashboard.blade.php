@extends('layouts.app')

@section('content')
    <!-------------------------------------- Dashboard Alumno  ----------------------------->

    <div class="row">
        <div class="d-flex col-12 align-items-center mb-2">
            <img src="{{ Auth::user()->foto }} " alt="image" class="img-fluid rounded-circle img-thumbnail me-3"
                 style="width:120px !important; height:120px !important">
            <h1>Hola {{ Auth::user()->nombre . ' ' . Auth::user()->apellidos }}</h1>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <h4 class="header-title mt-0 mb-4">Clases programadas para hoy</h4>
                    <div class="text-center">
                        <h2 class="fw-normal text-pink" data-plugin="counterup">5894</h2>
                        <h5>Clases</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Clases impartidas</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70"
                                    height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70"
                                    data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58" data-skin="tron"
                                    data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                                    style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;">
                            </div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Clases Programadas</h4>

                    <div class="widget-chart-1">
                        <div class="widget-chart-box-1 float-start" dir="ltr">
                            <!--VS mes anterior Dejarlo hasta el final -->
                            <div style="display:inline;width:70px;height:70px;"><canvas width="70"
                                    height="70"></canvas><input data-plugin="knob" data-width="70" data-height="70"
                                    data-fgcolor="#f05050 " data-bgcolor="#F9B9B9" value="58" data-skin="tron"
                                    data-angleoffset="180" data-readonly="true" data-thickness=".15" readonly="readonly"
                                    style="width: 39px; height: 23px; position: absolute; vertical-align: middle; margin-top: 23px; margin-left: -54px; border: 0px; background: none; font: bold 14px Arial; text-align: center; color: rgb(240, 80, 80); padding: 0px; appearance: none;">
                            </div>
                        </div>

                        <div class="widget-detail-1 text-end">
                            <h2 class="fw-normal pt-2 mb-1"> 256 </h2>
                            <p class="text-muted mb-1">Totales</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <h4 class="header-title mt-0 mb-4">Alumnos inscritos</h4>
                    <div class="text-center">
                        <h2 class="fw-normal text-pink" data-plugin="counterup">5894</h2>
                        <h5>Alumnos</h5>
                    </div>
                </div>
            </div>
        </div>

    </div> --}}
	<?php
	/*echo  Auth::user()->id;
	echo "<pre>";
    print_r(Auth::user());
	echo "</pre>";*/
	
	?>
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
                            <?php
							
							if($win['titulo']=='Alumnos'){
								?>
                                <a href="{{route('alumnos.profesor.index')}}" class="text-muted mb-1">Ver mas</a>
                                <?php
							}
							elseif($win['titulo']=='Clases Impartidas'){
							$data=array("0","4");
							?>
                                <a href="{{route('clases.profesor.index',$data)}}" class="text-muted mb-1">Ver mas</a>
                                <?php
							}
							elseif($win['titulo']=='Clases Programadas'){
							$data=array("0","4");
							?>
                                <a href="{{route('clases.profesor.index',$data)}}" class="text-muted mb-1">Ver mas</a>
                                <?php
							}
							?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    @endforeach

    <div class="row">
        <!-- siguientes clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3"><i class="mdi mdi-notification-clear-all me-1"></i> Siguientes
                        clases</h4> <!--las siguientes 6 clases -->

                    <ul class="list-group mb-0 user-list">
                        @foreach ($clasesProgramadas as $claseProgramada)
                            <li class="list-group-item">
                                <a href="{{ route('ficha.show', [$claseProgramada->idClase, Auth::user()->id, $claseProgramada->idAlumno]) }}"
                                    class="user-list-item">
                                    <div class="user float-start me-3">
                                        <i class="mdi mdi-circle text-primary"></i>
                                    </div>
                                    <div class="user-desc overflow-hidden">
                                        <h5 class="name mt-0 mb-1"> {{ $claseProgramada->nombreMateria }} </h5>
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

        <!-- Alumnos con más clases -->
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mt-0 mb-4">Alumnos con más clases</h4> <!--el top 6-->

                    @foreach ($listAlumnos as $list)
                        <a href="#">
                            <h5 class="mt-0"> {{ $list['nombreUsuario'] . ' ' . $list['apellidos'] }} <span
                                    class="text-{{ $list['color'] }} float-end"> {{ $list['porcentaje'] }}%</span></h5>
                        </a>
                        <div class="progress progress-bar-alt-{{ $list['color'] }} progress-sm mt-0 mb-3">
                            <div class="progress-bar bg-{{ $list['color'] }} progress-animated wow animated animated"
                                role="progressbar" aria-valuenow="{{ $list['porcentaje'] }}" aria-valuemin="0"
                                aria-valuemax="100"
                                style="width: {{ $list['porcentaje'] }}%; visibility: visible; animation-name: animationProgress;">
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>

        <!-- Calendarios -->
        <div class="col-xl-6 col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-4">Horario</h4>
                    <div id="calendar"></div>
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
            let ruta = 'https://techneektutor.com/sistema/calendario/alumno/' + idSujeto + '/1';
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
                },
                eventClick: function(info) {
                    let idClase = info.event.id;
                    $.ajax({
                        type: "GET",
                        url: "https://techneektutor.com/sistema/calendario/admin/" + idClase,
                        datatype: "json",
                        success: function(data) {
                            console.log(data);
                            let ruta = 'https://techneektutor.com/sistema/clases/ficha/' +
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
