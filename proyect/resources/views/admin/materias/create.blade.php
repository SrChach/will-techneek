@extends('layouts.app')

@section('content')
    <div class="col-md-12 col-lx-12">
        <div class="card">
            <h4 class="card-header display-6">Agregar Materia</h4>
            <div class="card-body"> 
                <div class="row">
                    <div class="col-lg-12">
                        <form id="formmateria" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre de la Materia</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre">
                                    </div>
                                    <div class="mb-3">
                                        <label for="icono" class="form-label">Agregar Icono</label>
                                        <input type="file" id="icono" name="icono" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Costo</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">$</span>
                                            <input type="number" step="0.01" class="form-control" id="costo"
                                                name="costo" placeholder="0.0">
                                        </div>
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
                                            <tr>
                                                <td>
                                                    <input type="text" id="numero" name="numero[]"
                                                        class="form-control" placeholder="Número">
                                                </td>
                                                <td>
                                                    <input type="text" id="tituolo" name="titulo[]"
                                                        class="form-control" placeholder="Tema">
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
                                <div class="row">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="btn btn-success rounded-pill waves-effect waves-light">
                                            <span class="btn-label"><i class="mdi mdi-plus-circle"></i></span>Agregar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->
            </div> <!-- end card-body -->
        </div> <!-- end card -->
    </div>
@endsection
