@extends('layouts.app')

@section('content')
    <style>
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
            text-align: center !important;
        }
    </style>
    <div class="col-12">
        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-desk-lamp"></i> Agregar clase</h4>
        </div>
    </div>
    <div class="col-12 col-md-7">

        
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-book-education-outline"></i> Selecciona materia</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
						@if($errors->eny)
                        
                            @foreach ($errors->all() as $error)
                            	<div class="alert alert-danger" role="alert">
                                <li>{{ $error }}</li>
                                </div>
                            @endforeach
                        
                        @endif
                        <div class="row mt-2">

                            @foreach ($listaMateria as $materia)
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" requider type="radio" value="{{ $materia->id }}"
                                            id="materia{{ $materia->id }}" name="materia[]"
                                            onclick="dataMateria({{ $materia->id }})" form="formCreateClase">
                                        <label class="form-check-label" for="materia{{ $materia->id }}">
                                            {{ $materia->nombre }} </label>
                                    </div>
                                    
                                </div> <!-- end col -->
                            @endforeach
                        </div> <!-- end row-->
                    </div>
                    <!-- end col -->

                </div> <!-- end row-->
            </div>
        </div> <!-- end card-->

        <!-- obtencion de temario -->
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-playlist-edit"></i> Selecciona tema</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" data-select2-id="7">
                    
                        <select class="from-select form-control select2-hidden-accessible" data-toggle="select2" data-width="100%" data-select2-id="1" tabindex="-1" aria-hidden="true" id="listTemario" name="listTemario" form="formCreateClase" required>
                            <option  disabled value="">Selecciona un Tema</option>
                            <option value="1">General</option>
                        </select>
                        @error('listTemario')
                            <span class="text-danger msg_error PosicionMensaje">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Seleccion de horas de clase -->
        <div class="card" id="fichaClase" style="display: none">
            <h5 class="card-header"><i class="mdi mdi-clipboard-check-outline"></i> Seleccionar Horas </h5>
            <div class="card-body">
                <h4 class="mb-3 header-title"></h4>
                <div class="row mb-3">
                    <label for="inputEmail3" class="col-4 col-md-3 col-form-label">Horas</label>
                    <div class="d-flex col-5 col-md-4">
                        <button type="button"
                            class="btn btn-outline-danger btn-xs waves-effect waves-light"onclick="restarHoras()"><i
                                class="mdi mdi-minus-thick"></i></button>
                        <input type="number" form="formCreateClase" id="horas" name="horas" class="border-0 bg-transparent col-3"
                            form="formPago" value="1" tabindex="-1" readonly>
                        <button type="button"
                            class="btn btn-outline-success btn-xs waves-effect waves-light"onclick="sumarHoras()"><i
                                class="mdi mdi-plus-thick"></i></button>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3 col-md-3 col-form-label">Costo por hora</label>
                    <div class="col-5 col-md-3">
                        <input type="text" form="formCreateClase" id="subtotal" name="subtotal" class="form-control text-center border-0 bg-transparen" value=""
                            tabindex="-1" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-3 col-md-3 col-form-label">TOTAL</label>
                    <div class="col-5 col-md-3">
                        <input type="text" form="formCreateClase" id="total" name="total" form="formPago" class="form-control text-center border-0 bg-transparen"
                            value="" tabindex="-1" readonly>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <!-- Calendar Row -->
    <div class="col-12 col-md-5">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-calendar"></i> Horarios disponibles</h5>
            <div class="card-body">
                <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    Los horarios son informativos, más adelante agendarás tu clase <br>
                    <b><i>Nota: Los horarios se calculan en los siguientes 3 meses</i></b>
                </div>
                <div id="calendar"></div>
                <div id="fichaProfesores"></div>

            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div> <!-- end col -->
    <!-- Calendar End -->

    <div class="col-12 col-md-12 mb-3">
        <form id="formCreateClase" method="POST" action="{{ route('pedidos.store') }}">
            @csrf
            <button class="btn btn-xl font-16 btn-success" id="btn-new-event">Siguiente<span class="btn-label-right"><i
                        class="mdi mdi-chevron-double-right"></i></span></button>
        </form>
    </div>
@endsection
@section('scripts')
    <script>
        function dataMateria(id) {
            console.log(id);
            //! obtener temario
            obtenerTemario(id);
            //? obtener calendario
            getCalendarMateria(id);
            //* obtener info materia
            infoMateria(id);
        }

        function obtenerTemario(id) {
            console.log('obteneer temario de la materia: ' + id);

            $.ajax({
                url: "https://techneektutor.com/sistema/tema/lista/" + id,
                type: "get",
                dataType: "json",
                success: function(data) {
                    $('#listTemario').empty();
                    //console.log(data);
                    $('#listTemario').append("<option selected disabled>Selecciona un Tema</option>");
                    $('#listTemario').append("<option value='1' >General</option>");
                    for (var value of data) {
                        //console.log(value);
                        $('#listTemario').append("<option value='" + value.id + "' >" + value.numero + " - " +
                            value.nombre + "</option>");
                    }
                    var calendarEl = document.getElementById('calendar');
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,basicWeek,basicDay',
                        },
                        locale: 'es',
                        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                            'Agosto',
                            'Septiembre',
                            'Octubre', 'Noviembre', 'Diciembre'
                        ],
                        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep',
                            'Oct',
                            'Nov', 'Dic'
                        ],
                        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes',
                            'Sábado'
                        ],
                        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                        events: [{ // this object will be "parsed" into an Event Object
                            title: 'evento prueba', // a property!
                            start: '2023-09-25', // a property!
                            end: '2023-09-27' // a property! ** see important note below about 'end' **
                        }],

                        customButtons: {
                            prev: {
                                text: 'Prev',
                                click: function() {
                                    console.log(date.month());
                                    // do the original command
                                    calendar.prev();
                                }
                            },
                            next: {
                                text: 'Next',
                                click: function() {
                                    // do the original command
                                    calendar.next();
                                }
                            },
                        }
                        //-----Fin Evento Click   
                    });
                    calendar.render();
                },
                error: function(request, error) {
                    console.log("Request: " + JSON.stringify(request));
                },
            });
        }

        function getCalendarMateria(id) {
            console.log(id);
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
        }

        function infoMateria(id) {
            
			$.ajax({
              url: "https://techneektutor.com/sistema/peticion/materia/" + id,
              type: "get",
              dataType: "json",
              success: function (data) {
                $('#fichaClase').show();
                $('#subtotal').val(data.costo);
                $('#total').val(data.costo);
              },
              error: function (request, error) {
                console.log("Request: " + JSON.stringify(request));
              },
            });
			
			$.ajax({
              url: "https://techneektutor.com/sistema/pedidos/profesoresMateria/"+id,
              type: "get",
              dataType: "text",
              success: function (data) {
                $('#fichaProfesores').html(data);
              },
              error: function (request, error) {
              },
            });
			
			
			//alert("paso 22222222"+id);
        }
    </script>
@endsection
