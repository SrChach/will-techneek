@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
        <h2 class="card-header"><i class="mdi mdi-desk-lamp"></i>Mis clases</h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-12">
                            <form  class="d-flex flex-wrap align-items-center justify-content-sm-end">
                            <label for="example-select" class="form-label ms-2 me-2">Estado de la Clase</label>
                            <div class="me-sm-2">
                            <select class="form-select" id="estado" name="estado">
                                <option disabled selected>Seleccionar un estado</option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}"> {{ $estado->nombre }} </option>
                                @endforeach
                            </select>
                            </div>
                            <label for="example-date" class="form-label ms-2 me-2">Fecha de inicio</label>
                            <div>
                            <input class="form-control" id="inicio" type="date" name="inicio">
                            </div>
                            <label for="example-date" class="form-label ms-2 me-2">Fecha de fin</label>
                            <div>
                            <input class="form-control" id="fin" type="date" name="fin">
                            </div>
                            <button type="submit" class="btn btn-outline-primary rounded-pill waves-effect waves-light ms-2">Consultar</button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- tabla de resultados -->
    <!-- pendiente de poner foreach -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>ID CLASE</th>
                                <th>MATERIA</th>
                                <th>ALUMNO</th>
                                <th>FECHA - HORA</th>
                                <th>PAGO CLASE</th>
                                <th>STATUS</th>
                                <th>FICHA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>1</th>
                                <th>Español</th>
                                <th>Juan López</th>
                                <th>05-11-23 12:00pm</th>
                                <th>$15.<sup>50</sup></th>
                                <th><span class="badge bg-warning">Programada</span></th>
                                <th>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-info btn-xs"><i class="mdi mdi-message-video me-1"></i>Link</button>
                                        <button type="button" class="btn btn-success btn-xs"><i class="mdi mdi-lead-pencil me-1"></i>Detalles</button>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>2</th>
                                <th>Matemáticas</th>
                                <th>Juan López</th>
                                <th>05-11-23 12:00pm</th>
                                <th>$15.<sup>50</sup></th>
                                <th><span class="badge bg-warning">Pendiente de pago</span></th>
                                <th>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success btn-xs"><i class="mdi mdi-lead-pencil me-1"></i>Detalles</button>
                                    </div>
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body text-end">
                <b>Total $250.00</b>
            </div>
        </div>
    </div>
@endsection
