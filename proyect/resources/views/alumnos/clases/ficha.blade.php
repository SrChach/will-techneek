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
                        <img src="{{ $clase->iconoMateria }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h1 class="mt-0 mb-1">Clase de {{ $clase->materiaNombre }}</h1>
                        <h4 class="text-muted mb-2"><i class="mdi mdi-calendar"></i> {{ $clase->fecha }}  <br><i class="mdi mdi-clock-outline"></i>  {{ $clase->hora }}<br><i class="mdi mdi-bookmark"></i> Tema </h4>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="button" class="btn btn-success rounded-pill waves-effect waves-light me-3">
                    <span class="btn-label"><i class="mdi mdi-message-video"></i></span>Ir a videollamada
                </button>
                <button type="button" class="btn btn-danger rounded-pill waves-effect waves-light">
                    <span class="btn-label"><i class="mdi mdi-calendar-refresh"></i></span>Reagendar
                </button>
                
            </div>
        </div>
    </div>
   {{--  <div class="col-12 col-md-6">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-teach"></i> Profesor</h5>
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle avatar-lg me-3 flex-shrink-0">
                        <img src="{{ $clase->foto }}" class="img-fluid rounded-circle" alt="user">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h4 class="mt-0 mb-1">{{ $clase->nombre }} <span class="badge badge-outline-warning"><i class="fas fa-star"></i> 5.0</span></h4>
                        <p class="text-muted"> <i class=" fab fa-whatsapp"></i> 55 5555 5555</p>
                        <button type="button" class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">Detalles</button>
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
                        <h4 class="mt-0 mb-1"> {{ Auth::user()->nombre }} <span class="badge badge-outline-warning"><i class="fas fa-star"></i> 5.0</span></h4>
                        <p class="text-muted"> <i class=" fab fa-whatsapp"></i> 55 5555 5555</p>
                        <button type="button" class="btn-xs btn-soft-primary rounded-pill waves-effect waves-light">Detalles</button>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-12">
        <div class="card">
                <h4 class="card-header"><i class="mdi mdi-account-star"></i> 
                    Califica al Profesor {{ $clase->nombre }}
                </h4>
                {{-- <h4 class="card-header"><i class="mdi mdi-account-star"></i> 
                    Califica al alumno {{ Auth::user()->nombre }}
                </h4> --}} 
            <div class="card-body">
                <small>Tu califiación es privada</small>
                <div class="form-check">
                <input form="formBitacora" type="radio" id="customRadio1" name="stars" class="form-check-input" value="1">
                <label class="form-check-label" for="customRadio1"><i class="fas fa-star text-warning"></i></label>
                </div>
                <div class="form-check">
                <input form="formBitacora" type="radio" id="customRadio2" name="stars" class="form-check-input" value="2">
                <label class="form-check-label" for="customRadio2"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                </div>
                <div class="form-check">
                <input form="formBitacora" type="radio" id="customRadio3" name="stars" class="form-check-input" value="3">
                <label class="form-check-label" for="customRadio3"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                </div>
                <div class="form-check">
                <input form="formBitacora" type="radio" id="customRadio4" name="stars" class="form-check-input" value="4">
                <label class="form-check-label" for="customRadio4"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                </div>
                <div class="form-check">
                <input form="formBitacora" type="radio" id="customRadio5" name="stars" class="form-check-input" value="5">
                <label class="form-check-label" for="customRadio5"><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i></label>
                </div>
                <h4>Comentarios</h4>
                <textarea form="formBitacora" class="form-control" id="example-textarea" rows="3"></textarea>
            </div>
            <div class="card-footer">
                <form id="formBitacora">
                <button type="submit" class="btn btn-warning rounded-pill waves-effect waves-light">
                    <span class="btn-label"><i class="fas fa-star"></i></span>Calificar
                </button>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(':radio').change(function() {
            console.log('New star rating: ' + this.value);
        });
    </script>
@endsection
