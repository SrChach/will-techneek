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
            @if (Auth::user()->idRol == 3)
                <div class="card-footer">
                    <button type="button" class="btn btn-success rounded-pill waves-effect waves-light me-3">
                        <span class="btn-label"><i class="mdi mdi-message-video"></i></span>Ir a videollamada
                    </button>
                    <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-calendar-refresh"></i></span>Reagendar
                    </button>
                </div>
            @endif
        </div>
    </div>

    @if (intval($infoClase->estadoClase) >= 4)
        @if (Auth::user()->idRol == 1)
            <div class="col-12 col-md-6">
                <div class="card">
                    <h5 class="card-header"><i class="mdi mdi-teach"></i> Profesor</h5>
                    <div class="card-body widget-user">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle avatar-lg me-3 flex-shrink-0">
                                <img src="{{ $infoFichaProfesor->fotoProfesor }}" class="img-fluid rounded-circle"
                                    alt="user">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h4 class="mt-0 mb-1">
                                    {{ $infoFichaProfesor->nombreProfesor }} {{ $infoFichaProfesor->apellidosProfesor }}
                                    <span class="badge badge-outline-warning">
                                        <i class="fas fa-star"></i> {{ $infoFichaProfesor->calificacionProfesor }} </span>
                                </h4>
                                @isset($infoFichaProfesor->telefonoProfesor)
                                    <p class="text-muted"> <i class=" fab fa-whatsapp"></i>
                                        {{ $infoFichaProfesor->telefonoProfesor }} </p>
                                @endisset
                                <div class="mb-3">
                                    <label for="example-textarea" class="form-label">Comentarios</label>
                                    <textarea class="form-control" id="example-textarea" rows="5" disabled>
                                        {{ $infoFichaProfesor->comentariosProfesor }}
                                    </textarea>
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
                                    {{ $infoFichaAlumno->nombreAlumno }} {{ $infoFichaAlumno->apellidosAlumno }}
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
                                    <label for="example-textarea" class="form-label">Comentarios</label>
                                    <textarea class="form-control" id="example-textarea" rows="5" disabled>
                                        {{ $infoFichaAlumno->comentariosAlumno }}
                                    </textarea>
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
                    <div class="card-body">
                        <h5>Costo de la clase</h5>
                        <p class="text-muted">
                            {{-- $ 150.<sup>00</sup> --}}
                            ${{ $infoClase->costoMateria }}
                        </p>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                                    <span class="input-group-addon bootstrap-touchspin-postfix input-group-append">
                                        <span class="input-group-text">$</span>
                                    </span>
                                    <input data-toggle="touchspin" value=" {{ $infoClase->pagoProfesor }} " type="number"
                                        data-step="0.1" data-decimals="2" data-bts-postfix="$" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success rounded-pill waves-effect waves-light">
                            <span class="btn-label"><i class="fas fa-money-bill-alt"></i></span>Pagar
                        </button>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->idRol == 2 || Auth::user()->idRol == 3)
            <div class="col-12">
                <div class="card">
                    @if (Auth::user()->idRol == 2)
                        @php
                            $condicion = 1;
                        @endphp
                        <h4 class="card-header">
                            <i class="mdi mdi-account-star"></i> Califica al alumno
                        </h4>
                    @elseif(Auth::user()->idRol == 3)
                        @php
                            $condicion = 2;
                        @endphp
                        <h4 class="card-header">
                            <i class="mdi mdi-account-star"></i> Califica al Profesor
                        </h4>
                    @endif
                    <x-form.formulario id="formBitacora">
                        @csrf
                        <div class="card-body">
                            <label id="errorSarts"></label>
                            <small>Tu califiación es privada</small>
                            <div class="form-check">
                                <input type="radio" id="customRadio1" name="stars" class="form-check-input"
                                    value="1">
                                <label class="form-check-label" for="customRadio1">
                                    <i class="fas fa-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="customRadio2" name="stars" class="form-check-input"
                                    value="2">
                                <label class="form-check-label" for="customRadio2">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="customRadio3" name="stars" class="form-check-input"
                                    value="3">
                                <label class="form-check-label" for="customRadio3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="customRadio4" name="stars" class="form-check-input"
                                    value="4">
                                <label class="form-check-label" for="customRadio4">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="customRadio5" name="stars" class="form-check-input"
                                    value="5">
                                <label class="form-check-label" for="customRadio5"><i
                                        class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                        class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                        class="fas fa-star text-warning"></i></label>
                            </div>
                            <h4>Comentarios</h4>
                            <textarea class="form-control" id="comentarios" name="comentarios" rows="5">{{ $infoFichaProfesor->comentariosProfesor }}</textarea>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning rounded-pill waves-effect waves-light">
                                <span class="btn-label"><i class="fas fa-star"></i></span>Calificar
                            </button>
                        </div>
                    </x-form.formulario>
                </div>
            </div>
        @endif
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
                        url: "{{ route('ficha.store', [$infoClase->idClase, $condicion]) }}",
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
                                title: "Petición no procesada. Intentalo mas tarde,",
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
