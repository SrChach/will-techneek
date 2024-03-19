@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <h2 class="card-header"><i class="mdi mdi-desk-lamp"></i> Mis clases</h2>
                <div class="card-body">
                    <div class="row justify-content-between">
                        <div class="col-md-4">
                            <div class="mt-3 mt-md-0">
                                <a class="btn btn-success rounded-pill waves-effect waves-light"
                                    href="{{ route('pedidos.create') }}"><span class="btn-label"><i
                                            class="mdi mdi-plus-circle me-1"></i></span>Agregar Clase</a>
                            </div>
                        </div><!-- end col-->
                    </div>
                </div>
            </div>
        </div>

        <!--Tab Clases-->
        <div class="col-12">
            <div class="card">
                <h4 class="card-header"><i class="mdi mdi-desk-lamp"></i> Mis clases</h4>
                <div class="card-body">
                    <ul class="nav nav-pills navtab-bg nav-justified">
                        <li class="nav-item">
                            <a href="#programadas" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="mdi mdi-calendar"></i> Programadas
                                <span class="badge bg-light text-dark ms-1">{{ count($infoClasesProgramadas) }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tomadas" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                <i class="mdi mdi-desk-lamp"></i> Tomadas
                                <span class="badge bg-light text-dark ms-1">{{ count($infoClasesImpartidas) }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#porProgramar" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                <i class="mdi mdi-calendar"></i> Clases por programar

                                <span class="badge bg-light text-dark ms-1">{{ count($infoClasesPorProgramar) }}</span>

                            </a>
                        </li>
                    </ul>
                    
                    <div class="tab-content ">
                        <div class="tab-pane active table-responsive" id="programadas">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id Clase</th>
                                        <th>Materia</th>
                                        <th>Profesor</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($infoClasesProgramadas as $claseProgramada)
                                        <tr>
                                            <td> {{ $claseProgramada->idClase }} </td>
                                            <td class="text-info">
                                                {{ $claseProgramada->nombreMateria }}
                                            </td>
                                            <td class="text-info">
                                                <a href="{{ route('profesor.alumno.ficha', $claseProgramada->idUsuario) }}">
                                                    Prof. {{ $claseProgramada->nombreUsuario }}
                                                    {{ $claseProgramada->apellidosUsuario }}
                                                </a>
                                            </td>
                                            <td>
                                                <?php
                                                //echo $clase->fecha;
                                                $fecha = explode('-', $claseProgramada->fechaClase);
                                                //print_r($fecha);
                                                $nuevaFecha = $fecha['2'] . '-' . $fecha['1'] . '-' . $fecha['0'];
                                                
                                                ?>

                                                {{ $nuevaFecha }}


                                            </td>
                                            <td>
                                                {{ substr($claseProgramada->horaClase, 0, 5) }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ $claseProgramada->meeets }}" target="_blank"
                                                        class="btn btn-info btn-xs">
                                                        <i class="mdi mdi-message-video me-1"></i>Link
                                                    </a>
                                                    <a href="{{ route('ficha.show', [$claseProgramada->idClase, $claseProgramada->idUsuario, Auth::user()->id]) }}"
                                                        class="btn btn-success btn-xs">
                                                        <i class="mdi mdi-lead-pencil me-1"></i>Detalles
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="tomadas">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id Clase</th>
                                        <th>Materia</th>
                                        <th>Profesor</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($infoClasesImpartidas as $claseImpartida)
                                        <tr>
                                            <td> {{ $claseImpartida->idClase }} </td>
                                            <td class="text-info">
                                                {{ $claseImpartida->nombreMateria }}
                                            </td>
                                            <td class="text-info">
                                                <a href="{{ route('profesor.alumno.ficha', $claseImpartida->idUsuario) }}">
                                                    Prof. {{ $claseImpartida->nombreUsuario }}
                                                    {{ $claseImpartida->apellidosUsuario }}
                                                </a>
                                            </td>
                                            <td>

                                                <?php
                                                //echo $clase->fecha;
                                                $fecha = explode('-', $claseImpartida->fechaClase);
                                                //print_r($fecha);
                                                $nuevaFecha = $fecha['2'] . '-' . $fecha['1'] . '-' . $fecha['0'];
                                                
                                                ?>

                                                {{ $nuevaFecha }}
                                            </td>
                                            <td>
                                                {{ substr($claseImpartida->horaClase, 0, 5) }}
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('ficha.show', [$claseImpartida->idClase, $claseImpartida->idUsuario, Auth::user()->id]) }}"
                                                        class="btn btn-success btn-xs">
                                                        <i class="mdi mdi-lead-pencil me-1"></i>Detalles
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane" id="porProgramar">
                            <table class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Id Clase</th>
                                        <th>Materia</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($infoClasesPorProgramar as $clasePorProgramar)
                                        <tr>
                                            <td> {{ $clasePorProgramar->idClase }} </td>
                                            <td class="text-info">
                                                {{ $clasePorProgramar->nombreMateria }}
                                            </td>

                                            <td width="200">
                                                <div class="btn-group">
                                                    <a href=" {{ route('clases.alumno.asignar', $clasePorProgramar->idClase) }} "
                                                        class="btn btn-sm btn-primary rounded-pill waves-effect waves-light"><span
                                                            class="btn-label"><i
                                                                class="mdi mdi-calendar"></i></span>Programar
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Tab Clases-->
        <!-- Calendar Row -->
        <div class="col-12 col-md-8">
            <div class="card">
                <h4 class="card-header"><i class="mdi mdi-calendar"></i> Mi horario</h4>
                <div class="card-body">

                    <div id="calendar"></div>

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div> <!-- end col -->
        <!-- Calendar End -->


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
            let idSujeto = '{{ Auth::user()->id }}';
            let ruta = 'https://techneektutor.com/sistema/calendario/alumno/' + idSujeto + '/2';

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
                            let ruta = 'https://techneektutor.com/sistema/clases/ficha/alumno/' +
                                data.idClase;

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
