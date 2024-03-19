@extends('layouts.app')

@section('content')
    <style>
        label.flex-shrink-0.rounded-circle.avatar-xl.img-thumbnail.float-start.me-3 {
            background-image: url({{ Auth::user()->foto }});
            background-position: center;
            background-size: cover;
        }

        .avatar {
            background-repeat: no-repeat;
            background-position: center center;
            background-size: cover;
        }

        .container {
            position: relative;
        }

        .overlay {
            position: absolute;
            height: 100%;
            width: 100%;
            opacity: 0;
            transition: .5s ease;
            background-color: #008CBA;
        }

        .text {
            background-color: #3d3d3d85;
            vertical-align: middle;
            text-align: center;
            color: #fff;
            padding-top: 34px;
        }

        .container:hover .overlay {
            opacity: 1;
        }
    </style>
    <div class="col-sm-8">
        <div class="card">
            <h5 class="card-header">Mi perfil</h5>
            <div class="bg-picture card-body">
                <div class="d-flex align-items-middle">

                    <form id="formAvatar">
                        @csrf
                        <div class="container">
                            <label class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3"
                                alt="profile-image"></label>
                            <div class="overlay">
                                <div class="text text lex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3">
                                    <i class="fe-camera"></i> Editar foto
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="flex-grow-1 overflow-hidden">
                        <h3 class="m-0">
                            <i class="fe-user"></i> {{ Auth::user()->nombre }} {{ Auth::user()->apellidos }}
                        </h3>
                        <a href="mailto:{{ Auth::user()->email }}">
                            <h4 class="text-muted">
                                <i class="fe-mail"></i>
                                {{ Auth::user()->email }}
                            </h4>
                        </a>
                        @isset(Auth::user()->telefono)
                            <a href="https://wa.me/{{ Auth::user()->telefono }}" target="_blank">
                                <h4 class="text-muted">
                                    <i class="fab fa-whatsapp"></i>
                                    {{ Auth::user()->telefono }}
                                </h4>
                            </a>
                        @endisset
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!--/ meta -->

        <!-- seccion de edicion de datos -->
        <div class="card">
            <h5 class="card-header">Configuración</h5>
            <div class="card-body">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#foto" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-account-box"></i> Foto de Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#datos" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            <i class="mdi mdi-book-edit-outline"></i> Datos Generales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#passwordTab" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            <i class="mdi mdi-lock-open-check-outline"></i> Cambiar contraseña
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane show active" id="foto">
                        <form method="POST" action="{{ route('perfil.avatar') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">Selecciona tu imagen de perfil</label>
                                        <input type="file" id="avatar" name="avatar" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="pt-1 float-end">
                                        <button type="submit"
                                            class="btn btn-primary btn-sm waves-effect waves-light">Actualizar
                                            Foto</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="datos">
                        <form id="formDatos">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control"
                                            value=" {{ Auth::user()->nombre }} ">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos</label>
                                        <input type="text" id="apellidos" name="apellidos" class="form-control"
                                            value=" {{ Auth::user()->apellidos }} ">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="telefono" class="form-label">Teléfono</label>
                                        <input type="text" id="telefono" name="telefono" class="form-control"
                                            onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"
                                            value="{{ Auth::user()->telefono }}">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="nacimiento" class="form-label">Fecha de Nacimiento</label>
                                        <input type="date" id="nacimiento" name="nacimiento" class="form-control" maxlength="10"
                                            value="{{ Auth::user()->nacimiento }}">
                                    </div>
                                </div>
                            </div>
                            <div class="pt-1 float-end">
                                <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Actualizar
                                    datos</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="passwordTab">
                        <form id="formPassword" class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Contraseña">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="confirm_password" class="form-control"
                                            name="confirm_password" placeholder="Confirmar Contraseña">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-1 float-end">
                                <button type="submit" id="submitPass"
                                    class="btn btn-primary btn-sm waves-effect waves-light">Actualizar
                                    contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <!-- seccion de edicion de materias -->
        @if (Auth::user()->idRol == 2 || Auth::user()->idRol == 3)
            <div class="card">
                <h5 class="card-header">Mis Materias</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <p>
                                Seleccionas las materias que quieras impartir.
                            </p>
                        </div>
                        @foreach ($listMaterias as $materia)
                            <div class="col-12 col-md-3 form-check mb-2 form-check-primary">
                                <input class="selectMateria form-check-input rounded-circle" type="checkbox"
                                    value="{{ $materia->id }}" id="materia{{ $materia->id }}"
                                    @foreach ($materias as $materiauser) @if ($materiauser->idMateria == $materia->id) checked @endif @endforeach>
                                <label class="form-check-label" for="materia{{ $materia->id }}"> {{ $materia->nombre }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


        <!-- seccion de edicion de horarios -->
        @if (Auth::user()->idRol == 2)
            <div class="card">
                <h5 class="card-header">Mis Horarios</h5>
                <div class="card-body">
                    <form id="formHorario" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <p>
                                    Agregar tus horarios, <b>recuerda que tus clases duran 60 minutos apartir de la hora de
                                        inicio que selecciones</b>
                                </p>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="dia" class="form-label">Selecciona el día</label>
                                    <select class="form-select" id="dia" name="dia">
                                        @foreach ($listDias as $dia)
                                            <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="mb-3">
                                    <label for="hora" class="form-label">Selecciona la hora</label>
                                    <input type="text" id="hora" name="hora" class="form-control timepicker">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <button id="agregarhorario" type="submit"
                                    class="btn btn-success rounded-pill waves-effect waves-light">
                                    <span class="btn-label"><i class="mdi mdi-check-all"></i></span>Agregar
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="listItems" class="table mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Dia</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora Final</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($horarios as $horarioUser)
                                            <tr>
                                                <td scope="row"> {{ $horarioUser->dia }} </td>
                                                <td> {{ $horarioUser->hora_inicio }} </td>
                                                <td> {{ $horarioUser->hora_final }} </td>
                                                <td>
                                                    <a href="{{ route('perfil.horario.delete', $horarioUser->id) }}"
                                                        class="btn btn-danger rounded-pill waves-effect waves-light">
                                                        <span class="btn-label"><i
                                                                class="mdi mdi-close-circle-outline"></i></span>Eliminar
                                                    </a>
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
        @endif

    </div>
@endsection

@section('scripts')
    <script>
        $('.timepicker').timepicker({
            timeFormat: 'h:mm p',
            interval: 60,
            minTime: '10',
            maxTime: '10:00pm',
            defaultTime: '10',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        $('#listItems').dataTable({
            language: {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "pageLength": 5,
        });
    </script>
@endsection
