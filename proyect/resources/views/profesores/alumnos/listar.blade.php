@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h2 class="card-header"><i class="fas fa-graduation-cap"></i> Alumnos</h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-4">
                    </div><!-- end col-->
                    <div class="col-md-8">
                        <form class="d-flex flex-wrap align-items-center justify-content-sm-end">
                            <label for="status-select" class="me-2">Ordenar por</label>
                            <div class="me-sm-2">
                                <select class="form-select my-1 my-md-0" id="status-select">
                                    <option selected="">Todo</option>
                                    <option value="1">Nombre</option>
                                    <option value="2">Clases</option>
                                    <option value="3">Materias</option>
                                </select>
                            </div>
                            <label for="inputPassword2" class="visually-hidden">Buscar</label>
                            <div>
                                <input type="search" class="form-control my-1 my-md-0" id="inputPassword2" placeholder="Buscar...">
                            </div>
                        </form>
                    </div>
                </div> <!-- end row -->
            </div>
        </div> <!-- end card -->
    </div><!-- end col-->

    @foreach ($alumnos as $alumno)
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body widget-user">
                <div class="d-flex align-items-center">

                    <div class="">
                        <img src="{{ $alumno['foto'] }}" alt="image"
                            class="img-fluid rounded-circle img-thumbnail me-3"
                            style="width:120px !important; height:120px !important">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="mt-0 mb-1">{{ $alumno->nombre }} {{ $alumno->apellidos }}</h5>
                        <p class="text-muted mb-2 font-13 text-truncate">{{ $alumno->email }}</p>
                        <small class="text-success"><b>2 Tomadas</b></small> - 
                        <small class="text-warning"><b>3 Programadas</b></small><br>
                        <a href="{{ route('alumnos.profesor.show', $alumno->id) }}"><button type="button" class="btn btn-soft-primary rounded-pill btn-xs waves-effect waves-light mt-2">Detalles</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @endforeach
@endsection
