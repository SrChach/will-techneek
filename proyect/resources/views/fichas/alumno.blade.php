@extends('layouts.app')

@section('content')
    <style>
        .rating {
            display: inline-block;
            position: relative;
            height: 50px;
            line-height: 50px;
            font-size: 50px;
        }

        .rating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            cursor: pointer;
        }

        .rating label:last-child {
            position: static;
        }

        .rating label:nth-child(1) {
            z-index: 5;
        }

        .rating label:nth-child(2) {
            z-index: 4;
        }

        .rating label:nth-child(3) {
            z-index: 3;
        }

        .rating label:nth-child(4) {
            z-index: 2;
        }

        .rating label:nth-child(5) {
            z-index: 1;
        }

        .rating label input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .rating label .icon {
            float: left;
            color: transparent;
        }

        .rating label:last-child .icon {
            color: #000;
        }

        .rating:not(:hover) label input:checked~.icon,
        .rating:hover label:hover input~.icon {
            color: #09f;
        }

        .rating label input:focus:not(:checked)~.icon:last-child {
            color: #000;
            text-shadow: 0 0 5px #09f;
        }
    </style>
    <div class="col-12">
        <div class="card">
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="avatar-xl rounded-circle me-3 flex-shrink-0">
                        <img src="{{ $infoClase->iconoMateria }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h1 class="mt-0 mb-1">Clase de {{ $infoClase->materiaNombre }} </h1>
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
            @if (intval($infoClase->estadoClase) == 2 || intval($infoClase->estadoClase) == 3)
                <div class="card-footer">
                    <a href="{{ $infoClase->meets }}" target="_blank"
                        class="btn btn-success rounded-pill waves-effect waves-light me-3">
                        <span class="btn-label"><i class="mdi mdi-message-video"></i></span>Ir a videollamada
                    </a>
                    {{-- <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-calendar-refresh"></i></span>Reagendar
                    </button> --}}
                </div>
            @endif
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-teach"></i> Profesor</h5>
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle avatar-lg me-3 flex-shrink-0">
                        <img src="{{ $infoFichaProfesor->fotoProfesor }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1">{{ $infoFichaProfesor->nombreProfesor }} &nbsp; <span class="badge badge-outline-warning">  <i class="fas fa-star">  {{ round($promedioFinal, 1) }}</i>
                            </span></h4>
                        <p class="text-muted"> 

                            @isset($infoFichaProfesor->telefonoProfesor)
                                <i class=" fab fa-whatsapp"></i>
                                <a href="https://wa.me/52{{ $infoFichaProfesor->telefonoProfesor }}" target="_blank">
                                    {{ $infoFichaProfesor->telefonoProfesor }}
                                </a>
                            @endisset
                            <br><i class="fe-mail"></i> {{ $infoFichaProfesor->correoProfesor }}
                        </p>



                        <a href="{{ route('profesor.alumno.ficha', $infoFichaProfesor->idProfesor) }}"
                            class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">
                            Detalles
                        </a>

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
                        <img src="{{ Auth::user()->foto }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1"> {{ Auth::user()->nombre }} <span class="badge badge-outline-warning"><i class="fas fa-star"></i> 
                            @if ($promedioFinalAlumno == null)
                                0.0
                            @else
                                {{ $promedioFinalAlumno }} 
                            @endif
                            
                        </span></h4>
                        <p class="text-muted">
                            @isset(Auth::user()->telefono)
                                <i class=" fab fa-whatsapp"></i> {{ Auth::user()->telefono }} <br>
                            @endisset
                            <i class="fe-mail"></i> {{ Auth::user()->email }}
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @if (intval($infoClase->estadoClase) >= 4)
        <div class="col-12">
            <h4 class="header-title mb-4">Bitacora</h4>
            <ul class="nav nav-pills navtab-bg nav-justified">
                <li class="nav-item">
                    <a href="#calificacion" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                        <i class="mdi mdi-account-star"></i> Califica al profesor
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#retro" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                        <i class="mdi mdi-account-star"></i> Retroalimentación
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- tab de calificaión -->
                <div class="tab-pane show active" id="calificacion">
                    <x-form.formulario id="formBitacora">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Profesor </h5>
                                    <div class="card-body text-center">
                                        <img src="{{ $infoFichaProfesor->fotoProfesor }}" alt="image"
                                            class="img-fluid rounded-circle img-thumbnail" width="120" /> <br>
                                        <p class="text-muted font-13">
                                            <strong>
                                                {{ $infoFichaProfesor->nombreProfesor . ' ' . $infoFichaProfesor->apellidosProfesor }}
                                            </strong> <br>
                                            <strong> {{ $infoFichaProfesor->correoProfesor }} </strong>
                                        </p>
                                        @php
                                            $calificacion = $infoFichaProfesor->calificacionProfesor;
                                        @endphp
                                        @include('secciones.fichas.stars1')
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Comentarios </h5>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <textarea class="form-control" id="comentarios" name="comentarios" rows="7">{{ $infoFichaProfesor->comentariosProfesor }}</textarea>
                                        </div>
                                        <button type="submit"
                                            class="btn btn-warning rounded-pill waves-effect waves-light">
                                            <span class="btn-label"><i class="fas fa-star"></i></span>Calificar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-form.formulario>
                </div>
                <!-- tab de retroalimentacion -->
                <div class="tab-pane" id="retro">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header"><i class="mdi mdi-teach"></i> Observaciones </h5>
                                <div class="card-body">
                                    <p>
                                        @if (isset($infoFichaClase->observaciones_profesor))
                                            {{ $infoFichaClase->observaciones_profesor }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header"><i class="mdi mdi-teach"></i> Lista de Materiales de Apoyo </h5>
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
                                                                <a href="{{ $archivo->url }}" target="_blank"
                                                                    class="btn btn-success btn-sm rounded-pill waves-effect waves-light">
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
                        <div class="col-12 col-md-5">
                            <div class="card">
                                <h5 class="card-header"><i class="mdi mdi-teach"></i> Subir Tareas </h5>
                                <div class="card-body">
                                    <x-form.formulario
                                        action="{{ route('bitacora.subir.archivo', [$infoClase->idClase, 2]) }}"
                                        method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <!-- opcional -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="materiales" class="form-label">Materiales de
                                                        Apoyo</label>
                                                    <input type="file" id="materiales" name="materiales"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción
                                                        Corta</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="1"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12" style="display: flex; align-items: center;">
                                                <button type="submit"
                                                    class="btn btn-success rounded-pill waves-effect waves-light w-100">
                                                    Añadir
                                                </button>
                                            </div>
                                        </div>
                                    </x-form.formulario>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="card">
                                <h5 class="card-header"><i class="mdi mdi-teach"></i> Lista de </h5>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Descripción</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($archivos as $archivo)
                                                    @if ($archivo->idTipo == 1)
                                                        <tr>
                                                            <th scope="row"> {{ $archivo->id }} </th>
                                                            <td>{{ $archivo->descripcion }}</td>
                                                            <td>
                                                                <a href="{{ $archivo->url }}" target="_blank"
                                                                    class="btn btn-success btn-sm rounded-pill waves-effect waves-light">
                                                                    Ver
                                                                </a>
                                                                <a href="{{ route('bitacora.eliminar.archivo', $archivo->id) }}"
                                                                    class="btn btn-danger btn-sm rounded-pill waves-effect waves-light">
                                                                    Eliminar
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
                        <div class="col-12">
                            <div class="card">
                                <h5 class="card-header"><i class="mdi mdi-teach"></i> Observaciones Finales </h5>
                                <div class="card-body">
                                    @if (isset($infoFichaClase->observaciones_finales))
                                        <p>{{ $infoFichaClase->observaciones_finales }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    @endif
@endsection


@section('scripts')
    <script>
        $(':radio').change(function() {
            console.log('New star rating: ' + this.value);
        });

        $("#formBitacora")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    stars: {
                        required: true,
                    },
                    comentarios: {
                        required: true,
                    }
                },
                messages: {
                    stars: {
                        required: "Tu calificación es obligatoria.",
                    },
                    comentarios: {
                        required: "Tus comentarios son obligatorios.",
                    }
                },
                //errorLabelContainer: "#errorSarts",
                submitHandler: function(form) {
                    console.log('envio formulario');
                    let formData = new FormData(form);
                    let idClase = "{{ $infoClase->idClase }}";

                    $.ajax({
                        url: "https://techneektutor.com/sistema/calificar/sujeto/" + idClase + '/2',
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            let respuesta = JSON.parse(data);
                            console.log(respuesta);
                            if (respuesta.estado == true) {
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: respuesta.mensaje,
                                    showConfirmButton: false,
                                    timer: 3500,
                                });
                            } else if (respuesta.estado == false) {
                                Swal.fire({
                                    position: "center",
                                    icon: "error",
                                    title: respuesta.mensaje,
                                    showConfirmButton: false,
                                    timer: 3500,
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Petición no procesada. Intentalo más tarde,",
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        },
                    });
                    return false;
                },
            });
    </script>
@endsection
