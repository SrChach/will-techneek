@extends('layouts.app')

@section('content')
    <!-- Col 1-->
    <div class="col-12 col-md-8">
        <div class="card">
            <h2 class="card-header">Ficha de Profesor</h2>

            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle avatar-xl img-thumbnail me-3 flex-shrink-0">
                        <img src="{{ $profesor->foto }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h3 class="mt-0 mb-1"><i class="fe-user"></i> {{ $profesor->nombre }} <span
                                class="badge badge-outline-warning ms-2"><i class="mdi mdi-star-outline"></i> <?php echo number_format($avgProfesor->calificacion, 2)?> </span>
                        </h3>
                        <a href="mailto:{{ $profesor->email }}" target="_blank">
                            <p class="text-muted mb-2 font-13 text-truncate"><i class="fe-mail"></i> {{ $profesor->email }}
                            </p>
                        </a>
                        @isset($profesor->telefono)
                            <a href="https://wa.me/52{{ $profesor->telefono }}" target="_blank">
                                <small class="text-success"><b><i class="fab fa-whatsapp"></i>
                                        {{ $profesor->telefono }}</b></small>
                            </a><br>
                        @endisset
                        <a href="{{ route('admin.clases.materia', [$profesor->id, 2]) }}"><button type="button"
                                class="btn btn-soft-info rounded-pill btn-xs waves-effect waves-light mt-2 me-2"><span
                                    class="btn-label"><i class="mdi mdi-teach"></i></span> Clases</button></a>
                        <a href=" {{ route('admin.alumnos.condicion', [$profesor->id, 2]) }} "><button type="button"
                                class="btn btn-soft-info rounded-pill btn-xs waves-effect waves-light mt-2 me-2"><span
                                    class="btn-label"><i class="fas fa-graduation-cap"></i></span> Alumnos</button></a>
                        @if ($profesor->idStatus == 1 || $profesor->idStatus == 2 || $profesor->idStatus == 3)
                            <button data-id="{{ $profesor->id }}" type="button"
                                class="btn btn-outline-danger rounded-pill btn-xs waves-effect waves-light mt-2 me-2 float-end"
                                onclick="suspender({{ $profesor->id }})">
                                Suspender
                            </button>
                        @elseif ($profesor->idStatus == 4)
                            <button type="button"
                                class="btn btn-outline-success rounded-pill btn-xs waves-effect waves-light mt-2 me-2 float-end"
                                onclick="activar({{ $profesor->id }})">
                                Activar
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-success" data-plugin="counterup">{{ $clasesImpartidas }}</h2>
                            <h4 class="text-muted"><i class="mdi mdi-teach me-1"></i> Clases impartidas</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-success" data-plugin="counterup">{{ $clasesProgramadas }}</h2>
                            <h4 class="text-muted"><i class="mdi mdi-calendar me-1"></i> Clases programadas</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <h2 class="fw-normal text-success" data-plugin="">${{ number_format($totalCosto) }}</h2>
                            <!-- <sup>00</sup> pendientee de colocar -->
                            <h4 class="text-muted"><i class="mdi mdi-currency-usd-circle me-1"></i> Valor en clase</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Col 2-->
    <div class="col-12 col-md-4">
        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-book-education-outline me-1"></i> Materias Registradas</h4>
            <div class="card-body">
                <ul class="list-group mb-0 user-list">
                    @foreach ($materiasRelacionadas as $materiaRelacionada)
                        
                        <li class="list-group-item">
                            <a href="{{route('materia.show', $materiaRelacionada->idMateria)}}" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="{{ $materiaRelacionada->icono }}" alt=""
                                        class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1"> {{ $materiaRelacionada->materia }} </h5>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- end Col 2-->
    <!-- Row 2-->
    <div class="row">
        <!-- Calendar -->
        <div class="col-12 col-md-8">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-calendar me-1"></i> Horario de clases</h5>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <!-- Calendar End -->
        <!-- Impartidas -->
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-teach me-1"></i> Últimas clases impartidas</h5>
                <div class="card-body">

                    @forelse ($infoClasImpar as $claseImpartida)
                        <ul class="list-group mb-0 user-list">
                            <li class="list-group-item">
                                <a href="{{ route('ficha.show', [$claseImpartida->idClase, $claseImpartida->idProfesor, $claseImpartida->idAlumno]) }}"
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
                    <a href="{{ route('admin.clases.materia', [$profesor->id, 2]) }}"
                        class="btn btn-outline-info rounded-pill waves-effect waves-light">Todas las
                        clases</a>
                </div>
            </div>
        </div>
        <!-- End Impartidas -->
        <!-- Programadas -->
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-desk-lamp me-1"></i> Clases programadas</h5>
                <div class="card-body">
                    @forelse ($infoClasProg as $claseProgramada)
                        <ul class="list-group mb-0 user-list">
                            <li class="list-group-item">
                                <a href="{{ route('ficha.show', $claseProgramada->idClase) }}"
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
                    <a href="{{ route('admin.clases.materia', [$profesor->id, 2]) }}"
                        class="btn btn-outline-info rounded-pill waves-effect waves-light">Todas las
                        clases</a>
                </div>
            </div>
        </div>
        <!-- End programadas -->
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
    </div>
    <!-- Ends Row 2-->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let idSujeto = '{{ $profesor->id }}';
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
                            //let ruta = 'https://techneektutor.com/sistema/clases/ficha/' +
                                //data.idClase + '/' + data.idProfesor + '/' + data.idAlumno;
							
							let ruta = 'https://techneektutor.com/sistema/clases/ficha/admin/' + data.idClase;
									
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
