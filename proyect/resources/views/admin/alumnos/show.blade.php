@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h5 class="card-header">Ficha de Alumno</h5>
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle avatar-xl img-thumbnail me-3 flex-shrink-0">
                        <img src="{{ $alumno->foto }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <?php
                    /*echo "<pre>";
						print_r($alumno);
					echo "</pre>";*/
					?>
                    <div class="flex-grow-1 overflow-hidden">
                        <h3 class="mt-0 mb-1"><i class="fe-user"></i> {{ $alumno->nombre }} <span
                                class="badge badge-outline-warning ms-2"><i class="mdi mdi-star-outline"></i> <?php echo number_format($avgAlumno->calificacion, 2)?> </span>
                        </h3>
                        <a href="mailto:{{ $alumno->email }}" target="_blank">
                            <p class="text-muted mb-2 font-13 text-truncate"><i class="fe-mail"></i> {{ $alumno->email }}
                            </p>
                        </a>
                        @isset($alumno->telefono)
                            <a href="https://wa.me/{{ $alumno->telefono }}" target="_blank">
                                <small class="text-info"><b><i class="fab fa-whatsapp"></i> {{ $alumno->telefono }}</b></small>
                            </a>
                        @endisset
                        <br>
                        <a href=" {{ route('admin.clases.materia', [$alumno->id, 3]) }} "><button type="button"
                                class="btn btn-soft-info rounded-pill btn-sm waves-effect waves-light mt-2 me-2"><span
                                    class="btn-label"><i class="mdi mdi-teach"></i></span> Clases</button></a>
                        @if ($alumno->idStatus == 1 || $alumno->idStatus == 2 || $alumno->idStatus == 3)
                            <button data-id="{{ $alumno->id }}" type="button"
                                class="btn btn-outline-danger rounded-pill btn-xs waves-effect waves-light mt-2 me-2 float-end"
                                onclick="suspender({{ $alumno->id }})">
                                Suspender
                            </button>
                        @elseif ($alumno->idStatus == 4)
                            <button type="button"
                                class="btn btn-outline-success rounded-pill btn-xs waves-effect waves-light mt-2 me-2 float-end"
                                onclick="activar({{ $alumno->id }})">
                                Activar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-success" data-plugin="counterup">{{ $clasesProgramadas }}</h2>
                            <h5><i class="mdi mdi-calendar me-1"></i> Clases programadas</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-success" data-plugin="counterup">{{ $clasesTomadas }}</h2>
                            <h5><i class="mdi mdi-desk-lamp me-1"></i> Clases tomadas</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-success" data-plugin="">${{ number_format($totalCosto) }}</h2>
                            <h5><i class="mdi mdi-currency-usd-circle me-1"></i> Valor de clases</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
            </div>
        </div>
        <!-- 3th Row -->
        <div class="row">
            <!-- Calendar Row -->
            <div class="col-12 col-md-4">
                <div class="card">
                    <h5 class="card-header"><i class="mdi mdi-calendar me-1"></i>Horario de clases</h5>
                    <div class="card-body">

                        <div id="calendar"></div>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div>
            <!-- Calendar End -->
            <!--impartidas-->
            <div class="col-12 col-md-3">
                <div class="card">
                    <h5 class="card-header"><i class="mdi mdi-teach me-1"></i> Últimas clases impartidas</h5>
                    <div class="card-body">

                        @forelse ($infoClasImpar as $claseImpartida)
                            <ul class="list-group mb-0 user-list">
                                <li class="list-group-item">
                                    <?php
                                    	/*echo "<pre>";
										print_r($claseImpartida);
									echo "</pre>"*/
									?>
                                    <a href="{{route('bitacora.administrador', $claseImpartida->idClase)}}"
                                        class="user-list-item">
                                        <div class="user float-start me-3">
                                            <i class="mdi mdi-circle text-primary"></i>
                                        </div>
                                        <div class="user-desc overflow-hidden">
                                            <h5 class="name mt-0 mb-1">{{ $claseImpartida->nombreMateria }} -
                                                {{ $claseImpartida->nombreAlumno }} </h5>
                                            <span class="desc text-muted font-12 text-truncate d-block">
                                            	<?php
												//echo $clase->fecha;
												$fecha=explode("-", $claseImpartida->fecha);
												//print_r($fecha);
												$nuevaFecha=$fecha['2']."-".$fecha['1']."-".$fecha['0'];
												$Hora=substr($claseImpartida->hora, 0, 5);
												?>
												{{ $nuevaFecha . ' ' .$Hora }}
                                                 </span>
                                            <!-- 2 enero - 10:00am -->
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        @empty
                            <div class="text-center">
                                <p class="text-muted">
                                    <i style="font-size: 70px;" class="mdi mdi-emoticon-confused-outline"></i>
                                </p>
                                <h5 class="text-muted">No encontramos nada por aquí</h5>
                            </div>
                        @endforelse

                    </div>
                    <div class="card-footer text-muted">
                        <a href="{{ route('admin.clases.materia', [$alumno->id, 3]) }}"
                            class="btn btn-outline-info rounded-pill waves-effect waves-light">Todas las
                            clases</a>
                    </div>
                </div>
            </div>
            <!--termina impartidas-->
            <!--Clases programadas-->
            <div class="col-12 col-md-3">
                <div class="card">
                    <h5 class="card-header"><i class="mdi mdi-desk-lamp me-1"></i> Clases programadas</h5>
                    <div class="card-body">
                        @forelse ($infoClasProg as $claseProgramada)
                            <ul class="list-group mb-0 user-list">
                                <li class="list-group-item">
                                    <a href="{{route('bitacora.administrador', $claseImpartida->idClase)}}"
                                        class="user-list-item">
                                        <div class="user float-start me-3">
                                            <i class="mdi mdi-circle text-primary"></i>
                                        </div>
                                        <div class="user-desc overflow-hidden">
                                            <h5 class="name mt-0 mb-1">{{ $claseProgramada->nombreMateria }} -
                                                {{ $claseProgramada->nombreAlumno }} </h5>
                                            <span class="desc text-muted font-12 text-truncate d-block">
                                                <?php
												//echo $clase->fecha;
												$fecha=explode("-", $claseProgramada->fecha);
												//print_r($fecha);
												$nuevaFecha=$fecha['2']."-".$fecha['1']."-".$fecha['0'];
												$Hora=substr($claseProgramada->hora, 0, 5);
												?>
												{{ $nuevaFecha . ' ' .$Hora }}
                                                </span>
                                            <!-- 2 enero - 10:00am -->
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        @empty
                            <div class="text-center">
                                <p class="text-muted">
                                    <i style="font-size: 70px;" class="mdi mdi-emoticon-confused-outline"></i>
                                </p>
                                <h5 class="text-muted">No encontramos nada por aquí</h5>
                            </div>
                        @endforelse
                    </div>
                    <div class="card-footer text-muted">
                        <a href="{{ route('admin.clases.materia', [$alumno->id, 3]) }}"
                            class="btn btn-outline-info rounded-pill waves-effect waves-light">Todas las
                            clases</a>
                    </div>
                </div>
            </div>
            <!--Clases programadas-->
        </div>
        <!-- End 3th Row -->

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
                                <a id="detallesClase" href="#"
                                    class="btn btn-info rounded-pill waves-effect waves-light">
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
                let idSujeto = '{{ $alumno->id}}';
                let ruta = 'https://techneektutor.com/sistema/calendario/alumno/' + idSujeto + '/2';

                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'es',
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
                                /*let ruta = 'https://techneektutor.com/sistema/clases/ficha/' +
                                    data.idClase + '/' + data.idProfesor + '/' + data.idAlumno;*/
								let ruta = 'https://techneektutor.com/sistema/clases/ficha/admin/' + data.idClase ;	

                                $("#spanEstado").removeClass();
                                $('#centermodal').modal('show');
                                $("#icon-materia").attr("src", data.icono);
                                $("#icon-alumno").attr("src", data.avatarAlumno);
                                $("#icon-profesor").attr("src", data.avatarProfesor);
                                $('#folioClase').html('<b>Folio: </b>' + data.idClase);
                                $('#nombreMateria').html('<b>Materia: </b>' + data
                                    .nombreMateria);
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
