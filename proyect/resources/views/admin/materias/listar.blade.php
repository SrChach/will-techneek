@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h2 class="card-header">Materias</h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-4">
                        <a href="{{ route('materia.create') }}">
                            <button type="button" class="btn btn-success rounded-pill waves-effect waves-light">
                                <span class="btn-label"><i class="mdi mdi-plus-circle me-1"></i></span>Agregar Materia
                            </button></a>
                    </div><!-- end col-->
                    <div class="col-md-4">
                        <form id="formOrder" class="d-flex flex-wrap align-items-center justify-content-sm-end">
                            <label for="status-select" class="me-2">Ordenar por</label>
                            <div class="me-sm-2">
                                <select class="form-select my-1 my-md-0" id="orderSujeto" name="orden">
                                    <option value="asc">A - Z </option>
                                    <option value="desc">Z - A</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <form id="searchForm">
                            @csrf
                            <label for="search" class="visually-hidden">Buscar</label>
                            <div>
                                <input type="search" class="form-control my-1 my-md-0" id="search" name="search"
                                    placeholder="Buscar..." oninput="buscar()">
                            </div>
                        </form>
                    </div>
                </div> <!-- end row -->
            </div>
        </div>
    </div>

    <div id="coleccion" class="row">
        @foreach ($listaMaterias as $item)
            <div class="col-xl-4 col-md-6 cartaProduct" id="{{ $item['idMateria'] }}">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="d-flex align-items-center">
                            <div class=" me-3 flex-shrink-0">
                                <img src="{{ $item['iconoMateria'] }}"
                                    class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start" alt="user">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="mt-0 mb-1">{{ $item['nombreMateria'] }}</h5>
                                <p class="text-muted mb-2 font-13 text-truncate"><i class="fas fa-graduation-cap"></i>
                                    {{ $item['alumnos'] }} Alumnos</p>
                                <small class="text-blue"><b> {{ $item['clasesImpartidas'] }} Clases
                                        impartidas</b></small><br>
                                <small class="text-success"><b> {{ $item['clasesProgramadas'] }} Clases
                                        Programadas</b></small><br>
                                <a href="{{ route('materia.show', $item['idMateria']) }}"
                                    class="btn btn-primary rounded-pill btn-xs waves-effect waves-light mt-2 me-2">Detalles</a>
                                <a href="{{ route('materia.edit', $item['idMateria']) }}"
                                    class="btn btn-warning rounded-pill btn-xs waves-effect waves-light mt-2">Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        function buscar() {
            let valor = $('#search').val();
            let formData = new FormData(document.getElementById('searchForm'));
            $.ajax({
                url: "{{ route('search.materia') }}",
                type: "POST",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(data) {
                    //console.log(data);
                    $(".cartaProduct").hide();
                    for (let index = 0; index < data.length; index++) {
                        const element = data[index];
                        //console.log(element);
                        $('#' + element.id).show();
                    }

                },
                error: function(jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function(jqXHR, status) {
                    console.log('Petición realizada');
                }
            })

            console.log(valor);
        }

        $("#orderSujeto").change(function() {
            let option = $('select[id=orderSujeto]').val();
            console.log($('select[id=orderSujeto]').val());

            let formData = new FormData(document.getElementById('formOrder'));

            $.ajax({
                url: "{{ route('ordenar.materia') }}",
                type: "POST",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(data) {
                    //console.log(data);
                    $(".cartaProduct").hide();
                    for (let index = 0; index < data.length; index++) {
                        let card = `
                            <div class="col-xl-4 col-md-6 cartaProduct" id="${data[index].idMateria}">
                                <div class="card">
                                    <div class="card-body widget-user">
                                        <div class="d-flex align-items-center">
                                            <div class=" me-3 flex-shrink-0">
                                                <img src="${data[index].fotoMateria}"
                                                    class="flex-shrink-0 rounded-circle avatar-xl img-thumbnail float-start" alt="user">
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="mt-0 mb-1">${data[index].nombreMateria}</h5>
                                                <p class="text-muted mb-2 font-13 text-truncate"><i class="fas fa-graduation-cap"></i>
                                                    ${data[index].countAlumnos} Alumnos</p>
                                                <small class="text-blue"><b> ${data[index].countImpartidas} Clases impartidas</b></small><br>
                                                <small class="text-success"><b> ${data[index].countProgramadas} Clases
                                                        Programadas</b></small><br>
                                                <a href="{{ env('APP_URL') }}/materia/${data[index].idMateria}/show"
                                                    class="btn btn-primary rounded-pill btn-xs waves-effect waves-light mt-2 me-2">Detalles</a>
                                                <a href="{{ env('APP_URL') }}/materia/${data[index].idMateria}/edit"
                                                    class="btn btn-warning rounded-pill btn-xs waves-effect waves-light mt-2">Editar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        $("#coleccion").append(card);
                    }

                },
                error: function(jqXHR, status, error) {
                    console.log('Disculpe, existió un problema');
                },
                complete: function(jqXHR, status) {
                    console.log('Petición realizada');
                }

            })
        });
    </script>
@endsection
