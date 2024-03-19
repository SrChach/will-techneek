@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h2 class="card-header"><i class="mdi mdi-clipboard-check-outline"></i> Resumen de pedido</h2>
            <div class="bg-picture card-body">
                <div class="d-flex align-items-top">
                    <img src=" {{ $pedido->icono }} "
                        class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3" alt="profile-image">

                    <div class="flex-grow-1 overflow-hidden">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <h2 class="m-0"> {{ $pedido->materia }} </h2>
                                <p class="text-muted"><i> Tema {{ $pedido->numero }} {{ $pedido->tema }} </i></p>
                            </div>
                            <div class="col-12 col-md-6 text-end">
                                <p>

                                    <b>Folio: </b> {{ $pedido->folio }} -
                                    <span class="badge badge-outline-{{ $pedido->etiqueta }} rounded-pill">
                                        {{ $pedido->estadoPago }} </span> <br>
                                    <b>Horas Solicitadas: </b>{{ $pedido->horas }} <br>
                                    <b>Total Pagado: </b> ${{ $pedido->total }}
                                </p>
                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-desk-lamp"></i> Clases</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Profesor</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clases as $clase)
                                <tr>
                                    <th scope="row"> {{ $clase->id }} </th>
                                    <td>
                                        @if ($clase->idProfesor == null || $clase->idProfesor == '')
                                        @else
                                            <a href="{{ route('profesor.alumno.ficha', $clase->idProfesor) }}">
                                                {{ $clase->nombreProfesor }} {{ $clase->apellidosProfesor }} </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($clase->fecha == '' || $clase->fecha == null)
                                            {{ $clase->fecha }}
                                        @else
                                            {{ date('d-m-Y', strtotime($clase->fecha)) }}
                                        @endif
                                    </td>
                                    <td>
                                        @if ($clase->hora == '' || $clase->hora == null)
                                            {{ $clase->hora }}
                                        @else
                                            {{ date('h:s', strtotime($clase->hora)) }}
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-outline-{{ $clase->etiqueta }} rounded-pill">
                                            {{ $clase->estado }} </span>
                                    </td>
                                    <td>
                                        @if ($clase->idEstado == 1)
                                            <a href=" {{ route('clases.alumno.asignar', $clase->id) }} "
                                                class="btn btn-sm btn-primary rounded-pill waves-effect waves-light"><span
                                                    class="btn-label"><i class="mdi mdi-calendar"></i></span>Programar
                                            </a>
                                        @elseif($clase->idEstado == 2)
                                            <a href=" {{ route('ficha.show', [$clase->id, $clase->idProfesor, $clase->idAlumno]) }} "
                                                class="btn btn-sm btn-success rounded-pill waves-effect waves-light"><span
                                                    class="btn-label"><i class="mdi mdi-calendar"></i></span>Detalles
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Row -->
    <div class="col-lg-6">
        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-calendar"></i> Horarios Disponibles</h4>
            <div class="card-body">

                <div id="calendar"></div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div> <!-- end col -->
    <!-- Calendar End -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let id = "{{ $pedido->idMAteria }}";
            let link = "https://techneektutor.com/sistema/calendario/get/materia/" + id;
            console.log(link);
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
                    url: link,
                },
            });
            calendar.render();
        });
    </script>
@endsection
