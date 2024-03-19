@extends('layouts.app')

@section('content')
    <div class="col-12 col-md-6 col-lx-6">
        <div class="card">
            <h2 class="card-header">Editar materia</h2>
            <div class="card-body">
                <div class="row">
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <form action="{{ route('materia.update', $materia->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre de la Materia</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                        value="{{ $materia->nombre }}">
                                </div>
                                <div class="mb-3">
                                    <label for="icono" class="form-label">Editar Icono</label><br>
                                    <img src="{{ $materia->icono }}" class="rounded-circle avatar-xl img-thumbnail mb-2"
                                        alt="profile-image">
                                    <input type="file" id="icono" name="icono" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Costo</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">$</span>
                                        <input type="number" step="0.01" class="form-control" id="costo"
                                            name="costo" placeholder="0.0" value="{{ $materia->costo }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <button type="submit"
                                        class="btn btn-outline-success rounded-pill waves-effect waves-light">Actualizar
                                        Datos</button>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Temario</h5>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0" id="tableTemario">
                                        @php
                                            $count = 0;
                                        @endphp
                                        @foreach ($temas as $tema)
                                            <tr>
                                                <td>
                                                    <input type="text" id="numero" name="numero[]"
                                                        class="form-control" placeholder="Número"
                                                        value="{{ $tema->numero }}">
                                                </td>
                                                <td>
                                                    <input type="text" id="tituolo" name="titulo[]"
                                                        class="form-control" placeholder="Tema" value="{{ $tema->nombre }}">
                                                </td>
                                                <td>
                                                    <button type="button"
                                                        class="btn btn-outline-success rounded-pill waves-effect waves-light add"
                                                        onclick="añadirTema()"><i class="fas fa-plus"></i></button>
                                                    @if ($count > 0)
                                                        <button type="button"
                                                            class="btn btn-outline-danger rounded-pill waves-effect waves-light subtract button_eliminar_tema"><i
                                                                class="mdi mdi-trash-can"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $count = $count + 1;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td>
                                                <input type="text" id="numero" name="numero[]" class="form-control"
                                                    placeholder="Número">
                                            </td>
                                            <td>
                                                <input type="text" id="tituolo" name="titulo[]" class="form-control"
                                                    placeholder="Tema">
                                            </td>
                                            <td>
                                                <button type="button"
                                                    class="btn btn-outline-success rounded-pill waves-effect waves-light add"
                                                    onclick="añadirTema()"><i class="fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row-->
        </div> <!-- end card-body -->
    </div> <!-- end card -->
@endsection
