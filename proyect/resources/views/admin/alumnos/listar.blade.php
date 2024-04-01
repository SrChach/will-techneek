@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h2 class="card-header">Alumnos</h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                        <form id="formOrder" class="d-flex flex-wrap align-items-center justify-content-sm-end">
                            <label for="status-select" class="me-2">Ordenar</label>
                            <div class="me-sm-2">
                                <select class="form-select my-1 my-md-0" id="orderSuejeto" name="orden">
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
                    </div><!-- end col-->
                </div> <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col-->

    <div id="coleccion" class="row">
        @foreach ($listaAlumnos as $alumno)
            <div class="col-12 col-md-4 col-xl-3  cartaProduct" id="{{ $alumno['idAlumno'] }}">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle avatar-md img-thumbnail me-2 flex-shrink-0">
                                <img src="{{ $alumno['fotoAlumno'] }}" alt="image" class="img-fluid rounded-circle">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="mt-0 mb-1">{{ $alumno['nombreAlumno'] }} {{ $alumno['apellidosAlumno'] }}</h5>
                                <p class="text-muted mb-2 font-13 text-truncate">{{ $alumno['correoAlumno'] }}</p>
                                <small class="text-blue"><b>{{ $alumno['countImpartidas'] }} Impartidas </b></small> -
                                <small class="text-success"><b>{{ $alumno['countProgramadas'] }} Programadas</b></small><br>
                                <a href="{{ route('alumno.show', $alumno['idAlumno']) }}"><button type="button"
                                        class="btn btn-soft-primary rounded-pill btn-xs waves-effect waves-light mt-2">Detalles</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <script>
        function buscar() {
            let valor = $('#search').val();
            let formData = new FormData(document.getElementById('searchForm'));
            $.ajax({
                url: "{{ route('search.alumno') }}",
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

        $("#orderSuejeto").change(function() {
            let option = $('select[id=orderSuejeto]').val();
            console.log($('select[id=orderSuejeto]').val());

            let formData = new FormData(document.getElementById('formOrder'));

            $.ajax({
                url: "{{ route('ordenar.alumno') }}",
                type: "POST",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(data) {
                    console.log(data);
                    $(".cartaProduct").hide();
                    for (let index = 0; index < data.length; index++) {

                        let card = `
                            <div class="col-xl-3 col-md-6 cartaProduct" id="${data[index].idAlumno}">
                                <div class="card">
                                    <div class="card-body widget-user">
                                        <div class="d-flex align-items-center">
                                            <div class="">
                                                <img src="${data[index].fotoAlumno}" alt="image"
                                                    class="img-fluid rounded-circle img-thumbnail me-3"
                                                    style="width:120px !important; height:120px !important">
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <h5 class="mt-0 mb-1">${data[index].nombreAlumno} ${data[index].apellidosAlumno}</h5>
                                                <p class="text-muted mb-2 font-13 text-truncate">${data[index].correoAlumno}</p>
                                                <small class="text-blue"><b>${data[index].countImpartidas} Impartidas </b></small> -
                                                <small class="text-success"><b>${data[index].countProgramadas} Programadas</b></small><br>
                                                <a href="{{ env('APP_URL') }}/alumno/${data[index].idAlumno}/show"><button type="button"
                                                        class="btn btn-soft-primary rounded-pill btn-xs waves-effect waves-light mt-2">Detalles</button></a>
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
