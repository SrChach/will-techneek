@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="avatar-xl rounded-circle me-3 flex-shrink-0">
                        <img src="{{ $infoClase->iconoMateria }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h1 class="mt-0 mb-1">Clase {{ $idClase }} de {{ $infoClase->materiaNombre }} </h1>
                        <h4 class="text-muted mb-2">
                            <i class="mdi mdi-calendar"></i>
                            {{ $infoDia['nombreDiaSemana'] . ' ' . $fechaFormateada['diaMes'] . ',' }}
                            {{ $infoMes['nombreMes'] . ' ' . $fechaFormateada['year'] }}
                            <br>
                            <i class="mdi mdi-clock-outline"></i>
                            {{ $fechaFormateada['horaCeros'] . ':00 ' . $fechaFormateada['horaAtrr'] }}
                            <br>
                            <i class="mdi mdi-bookmark"></i> {{ $infoClase->temaNombre }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (intval($infoClase->estadoClase) >= 2)
        <div class="col-12">
            <ul class="nav nav-pills navtab-bg nav-justified">
            @if(intval($infoClase->estadoClase) >= 4)
                <li class="nav-item">
                    <a href="#calificacion" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                        <i class="mdi mdi-account-star"></i> Calificaciones
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#retro" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                        <i class="mdi mdi-account-star"></i> Retroalimentación
                    </a>
                </li>
            @endif
            </ul>
            <div class="tab-content">
                <!-- tab de calificaión -->
                <div class="tab-pane show active" id="calificacion">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h5 class="card-header"><i class="mdi mdi-teach"></i> Profesor</h5>
                                <div class="card-body widget-user">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle avatar-lg me-3 flex-shrink-0">
                                            <img src="{{ $infoFichaProfesor->fotoProfesor }}"
                                                class="img-fluid rounded-circle" alt="user">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h4 class="mt-0 mb-1">
                                                {{ $infoFichaProfesor->nombreProfesor }}
                                                {{ $infoFichaProfesor->apellidosProfesor }}
                                                <span class="badge badge-outline-warning">
                                                    <i class="fas fa-star"></i>
                                                    {{ $infoFichaProfesor->calificacionProfesor }} </span>
                                            </h4>
                                            @isset($infoFichaProfesor->telefonoProfesor)
                                                <p class="text-muted"> <i class=" fab fa-whatsapp"></i>
                                                    {{ $infoFichaProfesor->telefonoProfesor }} </p>
                                            @endisset
                                            <div class="mb-3">
                                                <p>
                                                    <b>
                                                        Comentarios
                                                    </b>
                                                </p>
                                                <p>
                                                    {{ $infoFichaProfesor->comentariosProfesor }}
                                                </p>
                                            </div>
                                            <a href="{{ route('profesor.show', $infoFichaProfesor->idProfesor) }}"
                                                class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">Detalles</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h5 class="card-header"><i class="fas fa-graduation-cap"></i> Alumno</h5>
                                <div class="card-body widget-user">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-lg me-3 flex-shrink-0">
                                            <img src="{{ $infoFichaAlumno->fotoAlumno }}" class="img-fluid rounded-circle"
                                                alt="user">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h4 class="mt-0 mb-1">
                                                {{ $infoFichaAlumno->nombreAlumno }}
                                                {{ $infoFichaAlumno->apellidosAlumno }}
                                                
                                                <span class="badge badge-outline-warning">
                                                    <i class="fas fa-star"></i>{{ $infoFichaAlumno->calificacionAlumno }}
                                                </span>
                                            </h4>
                                            @isset($infoFichaAlumno->telefonoAlumno)
                                                <p class="text-muted"> <i class=" fab fa-whatsapp"></i>
                                                    {{ $infoFichaAlumno->telefonoAlumno }}
                                                </p>
                                            @endisset
                                            <div class="mb-3">
                                                <p>
                                                    <b>
                                                        Comentarios
                                                    </b>
                                                </p>
                                                <p>
                                                    {{ $infoFichaAlumno->comentariosAlumno }}
                                                </p>
                                            </div>
                                            <a href="{{ route('alumno.show', $infoFichaAlumno->idAlumno) }}"
                                                class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">Detalles</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <h4 class="card-header"><i class="fas fa-money-bill-alt"></i> Pago a Profesor</h4>
                                <form id="formPagoProfesor" action="#">
                                    <div class="card-body">
                                        <h5>Costo de la clase</h5>
                                        <p class="text-muted">
                                            {{-- $ 150.<sup>00</sup> --}}
                                            ${{ $infoClase->costoMateria }}
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                                    <span
                                                        class="input-group-addon bootstrap-touchspin-postfix input-group-append">
                                                        <span class="input-group-text">$</span>
                                                    </span>
                                                    <input data-toggle="touchspin" value="{{ $infoClase->pagoProfesor }}"
                                                        type="number" data-step="0.1" data-decimals="2"
                                                        data-bts-postfix="$" class="form-control" id="cantidad" name="cantidad"
                                                        max="{{$infoClase->costoMateria}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit"
                                            class="btn btn-success rounded-pill waves-effect waves-light">
                                            <span class="btn-label"><i class="fas fa-money-bill-alt"></i></span>Pagar
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- tab de retroalimentacion -->
                @if(intval($infoClase->estadoClase) >= 4)
                    <div class="tab-pane" id="retro">
                        <div class="row">
                            <div class="col-12 col-md-12">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Observaciones </h5>
                                    <div class="card-body">
                                        <p>
                                        	@if(isset($infoFichaClase->observaciones_profesor))
                                                {{ $infoFichaClase->observaciones_profesor }}
                                        	@endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Lista de Materiales </h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Extensión</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($archivos as $archivo)
                                                        @if ($archivo->idTipo == 2)
                                                            <tr>
                                                                <th scope="row"> {{ $archivo->id }} </th>
                                                                <td> {{ $archivo->descripcion }} </td>
                                                                <td> {{ $archivo->extension }} </td>
                                                                <td>
                                                                    <a href=" {{ $archivo->url }} " target="_blank"
                                                                        class="btn btn-success btn-sm rounded-pill waves-effect waves-light w-100">
                                                                        Ver
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Lista de Tareas </h5>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Descripción</th>
                                                        <th>Extensión</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($archivos as $archivo)
                                                        @if ($archivo->idTipo == 1)
                                                            <tr>
                                                                <th scope="row"> {{ $archivo->id }} </th>
                                                                <td> {{ $archivo->descripcion }} </td>
                                                                <td> {{ $archivo->extension }} </td>
                                                                <td>
                                                                    <a href=" {{ $archivo->url }} " target="_blank"
                                                                        class="btn btn-success btn-sm rounded-pill waves-effect waves-light w-100">
                                                                        Ver
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Retroalimentación Final </h5>
                                    <div class="card-body">
                                        <p>
                                        	@if(isset($infoFichaClase->observaciones_finales))
                                            	{{ $infoFichaClase->observaciones_finales }}
                                            @endif    
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div> <!-- end col -->
    @endif
@endsection

@section('scripts')
    <script>
        let idClase = "{{$idClase}}";
        $("#formPagoProfesor")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    cantidad: {
                        required: true,
                        number: true,
                    }
                },

                messages: {
                    cantidad: {
                        required: "La cantidad es obligatoria.",
                        number: "Ingrese solo numeros.",
                        max: "La cantidad no puede sobrepasar el costo de la clase."
                    }
                },

                submitHandler: function(form) {
                    var datos = $(form).serialize();
                    $("#button").prop("disabled", true);
                    $.ajax({
                        type: "POST",
                        url: "https://techneektutor.com/sistema/clases/ficha/pago/profesor/"+idClase,
                        datatype: "json",
                        data: datos,
                        success: function(data) {
                            console.log(data); 
                            respuesta = JSON.parse(data);
                            console.log(respuesta); 
                            if (respuesta.estado == true) {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: respuesta.mensaje,
                                    showConfirmButton: false,
                                    timer: 3500,
                                });
                                window.setTimeout(function() {
                                    location.reload();
                                }, 3500);
                            } else if (respuesta.estado == false) {
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: data.mensaje,
                                    showConfirmButton: false,
                                    timer: 3500,
                                });
                                window.setTimeout(function() {
                                    location.reload();
                                }, 3500);
                            } 
                        },
                        error: function() {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Petición no procesada. Intentalo mas tarde,",
                                showConfirmButton: false,
                                timer: 3000,
                            });
                            window.setTimeout(function () {
                              location.assign("index.php");
                            }, 3500);
                        },
                    }); 
                    return false;
                },
            });
    </script>
@endsection
