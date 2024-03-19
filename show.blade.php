@extends('layouts.app')

@section('content')
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <h5 class="card-header">Ficha de materia</h5>
            <div class="bg-picture card-body">
                <div class="d-flex align-items-top">
                    <img src="{{ $materia->icono }}"
                        class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3" alt="materia-image">

                    <div class="flex-grow-1 overflow-hidden">
                        <h3>{{ $materia->nombre }}</h3>
                        <p class="text-muted"><i class="mdi mdi-currency-usd-circle-outline"></i>${{ $materia->costo }}/hr
                        </p>
                        <a href=" {{ route('admin.clases.materia', [$materia->id, 1]) }} "><button type="button"
                                class="btn btn-soft-primary rounded-pill btn-sm waves-effect waves-light mt-2 me-2"><i
                                    class="mdi mdi-teach me-1"></i> Clases</button></a>
                        <a href=" {{ route('admin.alumnos.condicion', [$materia->id, 1]) }} "><button type="button"
                                class="btn btn-soft-primary rounded-pill btn-sm waves-effect waves-light mt-2 me-2"><i
                                    class="fas fa-user-graduate me-1"></i> Alumnos</button></a>
                        <a href="#"><button type="button"
                                class="btn btn-soft-primary rounded-pill btn-sm waves-effect waves-light mt-2 me-2"><i
                                    class="mdi mdi-playlist-edit"></i> Temario</button></a>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <h2 class="fw-normal text-success" data-plugin="counterup"> {{ $countAlumnos }} </h2>
                        <h4 class="text-muted"><i class="fas fa-user-graduate me-1"></i> Alumnos</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <h2 class="fw-normal text-success" data-plugin="counterup"> {{ $countClasesImpartidas }} </h2>
                        <h4 class="text-muted"><i class="mdi mdi-teach me-1"></i> Clases impartidas</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <h2 class="fw-normal text-success" data-plugin="counterup"> {{ $countClasesProgramadas }} </h2>
                        <h4 class="text-muted"><i class="mdi mdi-calendar me-1"></i> Clases programadas</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <h2 class="fw-normal text-success" data-plugin="">$ {{ $total }} <sup>00</sup></h2>
                        <h4 class="text-muted"><i class="mdi mdi-currency-usd-circle me-1"></i> Total </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Row 2 -->
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-calendar"></i> Horarios</h5>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-desk-lamp"></i>Últimas Clases</h5>
                <div class="card-body">

                    <!--botones tabs-->
                    <ul class="nav nav-pills navtab-bg nav-justified">
                        <li class="nav-item">
                            <a href="#impartidas" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="mdi mdi-teach me-1"></i> Impartidas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#programadas" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                <i class="mdi mdi-desk-lamp me-1"></i> Clases programadas
                            </a>
                        </li>
                    </ul>

                    <!--contenido tabs-->
                    <div class="tab-content">
                        <div class="tab-pane active" id="impartidas">
                            @if ($countClasesImpartidas > 0)
                                <ul class="list-group mb-0 user-list">
                                    @foreach ($infoClasesImpartidas as $claseImpartida)
                                        <li class="list-group-item">	
                                            <a href="{{ route('bitacora.administrador', $claseImpartida->idClase) }}" class="user-list-item">
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
                                                        
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            @else
                                <p class="text-muted text-center">
                                    <i style="font-size: 70px;" class="mdi mdi-emoticon-confused-outline"></i>
                                </p>
                                <h5 class="text-muted">No encontramos nada por aquí</h5>
                            @endif

                        </div>
                        <div class="tab-pane" id="programadas">
                            @if ($countClasesProgramadas > 0)
                                <ul class="list-group mb-0 user-list">
                                    @foreach ($infoClasesProgramadas as $claseProgramada)
                                        <li class="list-group-item">
                                            <a href="#" class="user-list-item">
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
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            @else
                                <p class="text-muted text-center">
                                    <i style="font-size: 70px;" class="mdi mdi-emoticon-confused-outline"></i>
                                </p>
                                <h5 class="text-muted">No encontramos nada por aquí</h5>
                            @endif
                        </div>

                    </div>
                </div>
                <div class="card-footer text-muted">
                    <a href="{{ route('admin.clases.materia', [$materia->id, 1]) }}" class="btn btn-outline-info rounded-pill waves-effect waves-light ">Todas las
                        clases</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Termina Row 2 -->
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-teach me-1"></i> Profesores</h5>
                <div class="card-body">
                    @if (sizeof($infoProfesores) > 0)
                        @foreach ($infoProfesores as $profesor)
                            <ul class="list-group mb-0 user-list">
                                <li class="list-group-item">
                                    <a href="#" class="user-list-item">
                                        <div class="user avatar-sm float-start me-2">
                                            <img src="{{ $profesor->fotoUsuario }}" alt=""
                                                class="img-fluid rounded-circle">
                                        </div>
                                        <div class="user-desc">
                                            <h5 class="name mt-0 mb-1"> {{ $profesor->nombreUsuario }} {{ $profesor->apellidosUsuario }} </h5>
                                            <p class="desc text-muted mb-0 font-12"> {{{ $profesor->emailUsuario }}} </p>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        @endforeach
                    @else
                        <p class="text-muted text-center">
                            <i style="font-size: 70px;" class="mdi mdi-emoticon-confused-outline"></i>
                        </p>
                        <h5 class="text-muted">No encontramos nada por aquí</h5>
                    @endif

                </div>
                <div class="card-footer text-muted">
                    <a href="{{ route('profesor.index') }}" class="btn btn-outline-info rounded-pill waves-effect waves-light">Todos los
                        profesores</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <h5 class="card-header"><i class="mdi mdi-playlist-edit"></i> Temario</h5>
                <div class="card-body">
                    <table id="datatableTemario" class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Numero</th>
                                <th>Tema</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($temas as $tema)
                                <tr>
                                    <td> {{ $tema->numero }} </td>
                                    <td> {{ $tema->nombre }} </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-muted">
                    <a href="#" class="btn btn-outline-info rounded-pill waves-effect waves-light">Temario
                        completo</a>
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
            let idSujeto = '{{$materia->id}}';
            let ruta = 'https://techneektutor.com/sistema/calendario/alumno/' + idSujeto + '/3';

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
                events: [{ // this object will be "parsed" into an Event Object
                    title: 'evento prueba', // a property!
                    start: '2023-09-25', // a property!
                    end: '2023-09-27' // a property! ** see important note below about 'end' **
                }],
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
                                    data.idClase + '/' + data.idProfesor + '/' + data.idAlumno;

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
