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
                    <button type="button" class="btn btn-success rounded-pill waves-effect waves-light me-3">
                        <span class="btn-label"><i class="mdi mdi-message-video"></i></span>Ir a videollamada
                    </button>
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
                    <div class="avatar-lg me-3 flex-shrink-0">
                        <img src="{{ Auth::user()->foto }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1"> {{ Auth::user()->nombre }}
                            <span class="badge badge-outline-warning">
                                <i class="fas fa-star"></i>
                                @if ($promedioFinalProfesor == null)
                                    0.0
                                @else
                                    {{ round($promedioFinalProfesor,1) }}
                                @endif
                            </span>
                        </h4>
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
    <div class="col-12 col-md-6">
        <div class="card">
            <h5 class="card-header"><i class="fas fa-graduation-cap"></i> Alumno</h5>
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle avatar-lg me-3 flex-shrink-0">
                        <img src="{{ $infoFichaAlumno->fotoAlumno }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1">{{ $infoFichaAlumno->nombreAlumno }} &nbsp; 
                            <span class="badge badge-outline-warning"> 
                                <i class="fas fa-star"></i>
                                @if ($promedioFinalAlumno == null)
                                    0.0
                                @else
                                    {{ round($promedioFinalAlumno,1) }}
                                @endif
                            </span>
                        </h4>
                        <p class="text-muted">

                            @isset($infoFichaAlumno->telefonoAlumno)
                                <i class=" fab fa-whatsapp"></i>
                                <a href="https://wa.me/52{{ $infoFichaAlumno->telefonoAlumno }}" target="_blank">
                                    {{ $infoFichaAlumno->telefonoAlumno }} <br>
                                </a>
                            @endisset
                            <i class="fe-mail"></i> {{ $infoFichaAlumno->correoAlumno }}
                        </p>



                        <a href="{{ route('profesor.alumno.ficha', $infoFichaAlumno->idAlumno) }}"
                            class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">
                            Detalles
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (intval($infoClase->estadoClase) >= 3)
        <div class="col-12">
            <ul class="nav nav-pills navtab-bg nav-justified">
                <li class="nav-item">
                    <a href="#calificacion" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                        <i class="mdi mdi-account-star"></i> Califica al alumno
                    </a>
                </li>
                @if (intval($infoClase->estadoClase) >= 3)
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
                    <p class="f-6">Tu califiación es privada</p>
                    <x-form.formulario id="formBitacora">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Alumno </h5>
                                    <div class="card-body text-center">
                                        <img src="{{ $infoAlumnoCalificado->fotoAlumno }}" alt="image"
                                            class="img-fluid rounded-circle img-thumbnail" width="120" /> <br>
                                        <p class="text-muted font-13">
                                            <strong>
                                                {{ $infoAlumnoCalificado->nombreAlumno . ' ' . $infoAlumnoCalificado->apellidoAlumno }}
                                            </strong> <br>
                                            <strong> {{ $infoAlumnoCalificado->correoAlumno }} </strong>
                                        </p>
                                        @php
                                            $calificacion = $infoFichaAlumno->calificacionAlumno;
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
                                            <textarea class="form-control" id="comentarios" name="comentarios" rows="7">{{ $infoFichaAlumno->comentariosAlumno }}</textarea>
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
                @if (intval($infoClase->estadoClase) >= 3)
                    <div class="tab-pane" id="retro">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Observaciones </h5>
                                    <div class="card-body">
                                        <x-form.formulario id="formObservaciones">
                                            <div class="mb-3">
                                                <textarea class="form-control" id="observacion" name="observacion" rows="5">{{ $infoFichaClase->observaciones_profesor }}</textarea>
                                            </div>
                                            <!-- boto de envio -->
                                            <button type="submit"
                                                class="btn btn-warning rounded-pill waves-effect waves-light">
                                                <span class="btn-label"><i class="fas fa-star"></i></span>
                                                Enviar observaciones
                                            </button>
                                        </x-form.formulario>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Subir Archivos </h5>
                                    <div class="card-body">
                                        <x-form.formulario
                                            action="{{ route('bitacora.subir.archivo', [$infoClase->idClase, 1]) }}"
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
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Lista de archivos </h5>
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
                                                        @if ($archivo->idTipo == 2)
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
                            <div class="col-12">
                                <div class="card">
                                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Observaciones Finales </h5>
                                    <div class="card-body">
                                        <x-form.formulario id="formObservacionesFinales">
                                            <div class="mb-3">
                                                <textarea class="form-control" id="observacionfinal" name="observacionfinal" rows="5">{{ $infoFichaClase->observaciones_finales }}</textarea>
                                            </div>
                                            <!-- boto de envio -->
                                            <button type="submit"
                                                class="btn btn-warning rounded-pill waves-effect waves-light">
                                                <span class="btn-label"><i class="fas fa-star"></i></span>
                                                Enviar observaciones finales
                                            </button>
                                        </x-form.formulario>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div> <!-- end card-->
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
                        required: "Tus comenntarios son obligatorias.",
                    }
                },
                //errorLabelContainer: "#errorSarts",
                submitHandler: function(form) {
                    console.log('envio formulario');
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('ficha.store', [$infoClase->idClase, 1]) }}",
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
                                title: "Petición no procesada. Intentalo mas tarde.",
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        },
                    });
                    return false;
                },
            });

        $("#formObservaciones")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    observacion: {
                        required: true,
                    }
                },
                messages: {
                    observacion: {
                        required: "Tus observaciones son obligatorias.",
                    }
                },
                //errorLabelContainer: "#errorSarts",
                submitHandler: function(form) {
                    console.log('envio formulario');
                    let formData = new FormData(form);
                    let ruta =
                        "https://techneektutor.com/sistema/clases/ficha/profesor/obs/{{ $infoClase->idClase }}";

                    $.ajax({
                        url: ruta,
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
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: respuesta.mensaje,
                                showConfirmButton: false,
                                timer: 3500,
                            });
                        },
                        error: function() {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Petición no procesada. Intentalo mas tarde.",
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        },
                    });
                    return false;
                },
            });

        $("#formMateriales")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    materiales: {
                        required: true,
                    },
                },
                messages: {
                    materiales: {
                        required: "Selecciona un archivo.",
                    },
                },
                //errorLabelContainer: "#errorSarts",
                submitHandler: function(form) {
                    console.log('envio formulario');
                    let formData = new FormData(form);
                    let ruta =
                        "https://techneektutor.com/sistema/clases/ficha/subir/material/{{ $infoClase->idClase }}";

                    $.ajax({
                        url: ruta,
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            /* let respuesta = JSON.parse(data);
                            console.log(respuesta);
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: respuesta.mensaje,
                                showConfirmButton: false,
                                timer: 3500,
                            }); */
                        },
                        error: function() {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Petición no procesada. Intentalo mas tarde.",
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        },
                    });
                    return false;
                },
            });

        $("#formObservacionesFinales")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    observacionfinal: {
                        required: true,
                    }
                },
                messages: {
                    observacionfinal: {
                        required: "Tus observaciones finales son obligatorias.",
                    }
                },
                //errorLabelContainer: "#errorSarts",
                submitHandler: function(form) {
                    console.log('envio formulario');
                    let formData = new FormData(form);
                    let ruta =
                        "https://techneektutor.com/sistema/clases/ficha/profesor/obsfin/{{ $infoClase->idClase }}";

                    $.ajax({
                        url: ruta,
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
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: respuesta.mensaje,
                                showConfirmButton: false,
                                timer: 3500,
                            });
                        },
                        error: function() {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Petición no procesada. Intentalo mas tarde.",
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
