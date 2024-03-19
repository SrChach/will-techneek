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
                        <img src="https://techneektutor.com/imagenes/materias/materia_1697926033.jpg"
                            class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h1 class="mt-0 mb-1">Clase de Materia 1</h1>
                        <h4 class="text-muted mb-2"><i class="mdi mdi-calendar"></i> 2023-11-08 <br><i
                                class="mdi mdi-clock-outline"></i> 11:00:00<br><i class="mdi mdi-bookmark"></i>
                            Tema </h4>
                    </div>
                </div>
            </div>
            {{-- <div class="card-footer">
                <button type="button" class="btn btn-success rounded-pill waves-effect waves-light me-3">
                    <span class="btn-label"><i class="mdi mdi-message-video"></i></span>Ir a videollamada
                </button>
                <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">
                    <span class="btn-label"><i class="mdi mdi-calendar-refresh"></i></span>Reagendar
                </button>
            </div> --}}
        </div>

    </div>

    <div class="col-12 col-md-6">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-teach"></i> Profesor</h5>
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle avatar-lg me-3 flex-shrink-0">
                        <img src="https://techneektutor.com/sistema/assets/images/users/user-1.jpg"
                            class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1">profesor 4 <span class="badge badge-outline-warning"><i
                                    class="fas fa-star"></i> 5.0</span></h4>
                        <p class="text-muted"> <i class=" fab fa-whatsapp"></i> 55 5555 5555</p>
                        <div class="mb-3">
                            <label for="example-textarea" class="form-label">Comentarios</label>
                            <textarea class="form-control" id="example-textarea" rows="5" disabled></textarea>
                        </div>
                        <button type="button"
                            class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">Detalles</button>
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
                        <img src="https://techneektutor.com/sistema/assets/images/users/user-1.jpg"
                            class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1"> alumno <span class="badge badge-outline-warning"><i class="fas fa-star"></i>
                                5.0</span></h4>
                        <p class="text-muted"> <i class=" fab fa-whatsapp"></i> 55 5555 5555</p>
                        <div class="mb-3">
                            <label for="example-textarea" class="form-label">Comentarios</label>
                            <textarea class="form-control" id="example-textarea" rows="5" disabled></textarea>
                        </div>
                        <button type="button"
                            class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">Detalles</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-----pago al profesor sólo lo ve el administrador--->
    <div class="col-12 col-md-6">
        <div class="card">
            <h4 class="card-header"><i class="fas fa-money-bill-alt"></i> Pago a Profesor</h4>
            <div class="card-body">
                <h5>Costo de la clase</h5>
                <p class="text-muted">$ 150.<sup>00</sup></p>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group bootstrap-touchspin bootstrap-touchspin-injected">
                            <span class="input-group-addon bootstrap-touchspin-postfix input-group-append">
                                <span class="input-group-text">$</span>
                            </span>
                            <input data-toggle="touchspin" value="18.20" type="number" data-step="0.1" data-decimals="2"
                                data-bts-postfix="$" class="form-control">
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
@endsection
