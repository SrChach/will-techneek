@extends('layouts.app')

@section('content')
    <div class="col-12 col-md-8">
        <div class="card">
            <div class="bg-picture card-body">
                <div class="d-flex align-items-top">
                    <img src="{{ $profesor->foto }}"
                        class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start me-3" alt="profile-image">

                    <div class="flex-grow-1 overflow-hidde">
                        <h2>
                            <i class="fe-user"></i>
                            {{ $profesor->nombre . ' ' . $profesor->apellidos }}
                        </h2>

                        <p class="text-muted">
                            @isset($profesor->telefono)
                                <a href="https://wa.me/52{{$profesor->telefono}}" target="_blank">
                                    <i class="fab fa-whatsapp"></i> {{ $profesor->telefono }}
                                </a><br>
                            @endisset

                            <i class="fe-mail"></i> {{ $profesor->email }}
                        </p>


                    </div>

                </div>

            </div>
        </div>

        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-desk-lamp"></i> Mis clases</h4>
            <div class="card-body">
                <ul class="nav nav-pills navtab-bg nav-justified">
                    <li class="nav-item">
                        <a href="#programadas" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                            <i class="mdi mdi-calendar"></i> Programadas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#tomadas" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                            <i class="mdi mdi-desk-lamp"></i> Tomadas
                        </a>
                    </li>
                </ul>
                <div class="tab-content ">
                    <div class="tab-pane active table-responsive" id="programadas">
                        <table id="listClasesProgramadas" class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Id Clase</th>
                                    <th>Materia</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clasesProgramadasWithProfesor as $claseProgramada)
                                    <tr>
                                        <td> {{ $claseProgramada->idClase }} </td>
                                        <td class="text-info">
                                            <a href="#">
                                                {{ $claseProgramada->nombreMateria }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime($claseProgramada->fechaClase)) }}
                                        </td>
                                        <td>
                                            {{ date('h:s a', strtotime($claseProgramada->horaClase)) }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ $claseProgramada->link }}" target="_blank"
                                                    class="btn btn-info btn-xs">
                                                    <i class="mdi mdi-message-video me-1"></i>Link
                                                </a>
                                                <a href="{{ route('ficha.show', [$claseProgramada->idClase, $claseProgramada->idProfesor, $claseProgramada->idAlumno]) }}"
                                                    class="btn btn-success btn-xs">
                                                    <i class="mdi mdi-lead-pencil me-1"></i>Detalles
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tomadas">
                        <table id="listClasesImpartidas" class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Id Clase</th>
                                    <th>Materia</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clasesImpartidasWithProfesor as $claseImpartida)
                                    <tr>
                                        <td> {{ $claseImpartida->idClase }} </td>
                                        <td class="text-info">
                                            <a href="#">
                                                {{ $claseImpartida->nombreMateria }}
                                            </a>
                                        </td>
                                        <td>
                                            {{ date('d-m-Y', strtotime($claseImpartida->fechaClase)) }}
                                        </td>
                                        <td>
                                            {{ date('h:s a', strtotime($claseImpartida->horaClase)) }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('ficha.show', [$claseImpartida->idClase, $claseImpartida->idProfesor, $claseImpartida->idAlumno]) }}"
                                                    class="btn btn-success btn-xs">
                                                    <i class="mdi mdi-lead-pencil me-1"></i>Detalles
                                                </a>
                                            </div>
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
    <div class="col-12 col-md-4">
        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-book-education-outline me-1"></i> Materias Tomadas </h4>
            <div class="card-body">
                <ul class="list-group mb-0 user-list">
                    @foreach ($materiasWithProfesor as $materia)
                        <li class="list-group-item">
                            <a href="#" class="user-list-item">
                                <div class="user avatar-sm float-start me-2">
                                    <img src="{{ $materia->iconoMateria }}" alt=""
                                        class="img-fluid rounded-circle">
                                </div>
                                <div class="user-desc">
                                    <h5 class="name mt-0 mb-1"> {{ $materia->nombreMateria }} </h5>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#listClasesProgramadas').dataTable({
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
            order: [
                [2, 'desc'],
                [3, 'asc']
            ]
        });

        $('#listClasesImpartidas').dataTable({
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
            order: [
                [2, 'desc'],
                [3, 'asc']
            ]
        });
    </script>
@endsection
