@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h2 class="card-header">Profesores</h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-4">
                        <div class="mt-3 mt-md-0">
                            <button type="button" class="btn btn-success rounded-pill waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target="#con-close-modal">
                                <span class="btn-label"><i class="mdi mdi-plus-circle me-1"></i></span>Agregar Profesor
                            </button>
                        </div>
                    </div><!-- end col-->
                    <div class="col-md-4">
                        <form id="formOrder" class="d-flex flex-wrap align-items-center justify-content-sm-end">
                            <label for="status-select" class="me-2">Ordenar por</label>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="coleccion">
        @foreach ($listaProfesor as $profesor)
            <div class="col-12 col-md-4 col-xl-3 cartaProduct" id="{{ $profesor['idProfesor'] }}">
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle avatar-md img-thumbnail me-2 flex-shrink-0">
                                <img src="{{ $profesor['fotoProfesor'] }}" class="img-fluid rounded-circle" alt="user">
                            </div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="mt-0 mb-1">{{ $profesor['nombreProfesor'] }} {{ $profesor['apellidosProfesor'] }}
                                </h5>
                                <p class="text-muted mb-2 font-13 text-truncate">{{ $profesor['correoProfesor'] }}</p>
                                <small class="text-success"><b>{{ $profesor['countImpartidas'] }} Impartidas</b></small> -
                                <small class="text-warning"><b>{{ $profesor['countProgramadas'] }}
                                        Programadas</b></small><br>
                                <a href="{{ route('profesor.show', $profesor['idProfesor']) }}"><button type="button"
                                        class="btn btn-soft-primary rounded-pill btn-xs waves-effect waves-light mt-2">Detalles</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <!-- sample modal content -->
    <div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Agregar Profesor</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formprofesor">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del Profesor</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="correo" class="form-label">Correo del Profesor</label>
                                    <input type="text" class="form-control" id="correo" name="correo">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="contraseña" class="form-label">Contraseña del Profesor</label>

                                    <!--<input type="password" class="form-control" id="contraseña" name="contraseña">-->

                                    <div class="input-group input-group-merge">
                                        <input type="password" id="contraseña" class="form-control" name="contraseña"
                                            placeholder="Contraseña">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirma" class="form-label">Confirma contraseña del Profesor</label>
                                    <!--<input type="password" class="form-control" id="confirma" name="confirma">-->

                                    <div class="input-group input-group-merge">
                                        <input type="password" id="confirma" class="form-control" name="confirma"
                                            placeholder="Comfirma Contraseña">
                                        <div class="input-group-text" data-password="false">
                                            <span class="password-eye"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <!--<div class="col-md-12">
                                                        <button type="submit" class="btn btn-info"><span class="btn-label"><i class="mdi mdi-plus-circle"></i></span>Agregar</button>
                                                    </div>-->
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-soft-danger rounded-pill waves-effect waves-light"
                        data-bs-dismiss="modal">
                        <span class="btn-label"><i class="mdi mdi-close-circle-outline"></i></span>Cancelar
                    </button>
                    <button type="submit" id="botonProfSubmit"
                        class="btn btn-success rounded-pill waves-effect waves-light">
                        <span class="btn-label"><i class="mdi mdi-plus-circle"></i></span>Agregar
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.modal -->

    <script>
        function buscar() {
            let valor = $('#search').val();
            let formData = new FormData(document.getElementById('searchForm'));
            $.ajax({
                url: "{{ route('search.profesor') }}",
                type: "POST",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(data) {
                    console.log(data);
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
                url: "{{ route('ordenar.profesor') }}",
                type: "POST",
                data: formData,
                processData: false, // tell jQuery not to process the data
                contentType: false,
                success: function(data) {
                    console.log(data);
                    $(".cartaProduct").hide();
                    for (let index = 0; index < data.length; index++) {

                        if (data[index].apellidosProfesor === null) {
                            var apellidos = "";
                        }

                        let card = `
                        <div class="col-6 col-md-4 col-xl-3 cartaProduct" id="${data[index].idProfesor}">
                            <div class="card">
                                <div class="card-body widget-user">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle avatar-xl img-thumbnail me-3 flex-shrink-0">
                                            <img src="${data[index].fotoProfesor}" class="img-fluid rounded-circle" alt="user">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="mt-0 mb-1">${data[index].nombreProfesor} ${apellidos}</h5>
                                            <p class="text-muted mb-2 font-13 text-truncate">${data[index].correoProfesor}</p>
                                            <small class="text-success"><b>${data[index].countImpartidas}  Impartidas</b></small> - 
                                            <small class="text-warning"><b>${data[index].countProgramadas}  Programadas</b></small><br>
                                            <a href="https://techneektutor.com/sistema/profesor/${data[index].idProfesor}/show"><button type="button" class="btn btn-soft-primary rounded-pill btn-xs waves-effect waves-light mt-2">Detalles</button></a>
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
