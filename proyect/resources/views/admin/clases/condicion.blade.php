@extends('layouts.app')

@section('content')
    <style>
        input.error,
        select.error {
            border-color: #ff5b5b;
        }

        label.error {
            color: #ff5b5b;
        }
    </style>

    <div class="col-12">
        <div class="card">
            <h2 class="card-header">Clases de {{ $informacion->nombre }} {{ $informacion->apellidos }} </h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <form id="formFiltre" class="d-flex flex-wrap align-items-center justify-content-sm-end" method="POST"
                            action="{{ route('filtro.condicion', [$informacion->id, $indicador]) }}">
                            @csrf
                            <label for="status-select" class="me-2">Estado de la clase</label>
                            <div class="me-sm-2">
                                <select class="form-select my-1 my-md-0" id="estado" name="estado">
                                    @foreach ($estados as $estado)
                                        @if (Auth::user()->idRol == 2)
                                            @if ($estado->id != 1)
                                                <option value="{{ $estado->id }}"> {{ $estado->nombre }} </option>
                                            @endif
                                        @else
                                            <option value="{{ $estado->id }}"> {{ $estado->nombre }} </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <label for="fechaInicio" class="ms-2 me-2">Fecha de inicio</label>
                            <div>
                                <input class="form-control my-1 my-md-0" id="fechaInicio" type="date" name="fechaInicio">
                            </div>
                            <label for="fechaFin" class="ms-2 me-2">Fecha de fin</label>
                            <div>
                                <input class="form-control" id="fechaFin" type="date" name="fechaFin">
                            </div>
                            <button type="submit"
                                class="btn btn-outline-primary rounded-pill waves-effect waves-light ms-2">Consultar</button>
                        </form>
                    </div>
                </div> <!-- end row -->
            </div>
        </div>
    </div>

    <!-- tabla de resultados -->
    <!-- pendiente de poner foreach -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="listItems" class="table mb-0">
                        <thead>
                            <tr>
                                @for ($i = 0; $i < sizeof($encabezados); $i++)
                                    <th>
                                        {!! $encabezados[$i] !!}
                                    </th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clasesList as $clase)
                                <tr>
                                    <th scope="row"> {{ $clase['idClase'] }} </th>
                                    <th @if ($indicador == 1) hidden @endif class="text-info"> <a
                                            href="{{ route('materia.show', $clase['idMateria']) }}">
                                            {{ $clase['nombreMateria'] }} </a></th>
                                    <td @if ($indicador == 3) hidden @endif class="text-info"><a
                                            href="{{ route('alumno.show', $clase['idAlumno']) }}"><strong>
                                                {{ $clase['nombreAlumno'] }} </strong></a></td>
                                    <td @if ($indicador == 2 || $indicador == 4) hidden @endif class="text-info">
                                        <a
                                            href=" @if ($clase['idProfesor'] != null) {{ route('profesor.show', $clase['idProfesor']) }} @endif "><strong>
                                                {{ $clase['nombreProfesor'] }} </strong></a>
                                    </td>
                                    <td>
                                    
                                        @isset($clase['fecha'])
                                            {{ date('d-m-Y', strtotime($clase['fecha'])) }} - {{ date('h:s a', strtotime($clase['hora'])) }}
                                        @endisset
                                    </td>
                                    <td @if ($indicador == 1 || $indicador == 2 || $indicador == 3) hidden @endif class="text-info">
                                    
                                        <?php $arraysumando[] = $clase['pago']; ?>
                                        {{ number_format($clase['pago'], 2) }}
                                    </td>
                                    <!-- falta formatear fecha y hora -->
                                    <td><span class="badge bg-{{ $clase['etiquetaEstados'] }} rounded-pill">
                                            {{ $clase['nombreEstado'] }} </span></td>
                                    <td>
                                        @if ($clase['idEstadoClase'] != 1 && $clase['idEstadoClase'] > 2)
                                            <a href="{{ route('bitacora.administrador', $clase['idClase']) }}" class="btn btn-success btn-xs"><i
                                                    class="mdi mdi-lead-pencil me-1"></i>Detalles</a>
                                        @elseif ($clase['idEstadoClase'] == 2)
                                            <a href="{{ route('bitacora.administrador', $clase['idClase']) }}" class="btn btn-success btn-xs"><i
                                                    class="mdi mdi-lead-pencil me-1"></i>Detalles</a>
                                            <a href="{{ $clase['link'] }}" class="btn btn-info btn-xs" target="_blank"><i
                                                    class="mdi mdi-message-video me-1"></i>Link</a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Totales -->
    <div class="col-12">
        <div class="card">
            <div class="card-body text-end">
                @isset($arraysumando)
                    <h4>Total $<?php if(isset($arraysumando))echo number_format(array_sum($arraysumando), 2); ?></h4>
                @endisset
            </div>
        </div>
    </div>
    <!-- Acaba Totales -->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/tableinit.js') }}"></script>
    <script>
        $("#formFiltre")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                rules: {
                    estado: {
                        required: true,
                    },
                    fechaInicio: {
                        required: true,
                    },
                    fechaFin: {
                        required: true,
                    }
                },

                messages: {
                    estado: {
                        required: "Selecciona un estado valido."
                    },
                    fechaInicio: {
                        required: "Ingresa una fecha de inicio.",
                    },
                    fechaFin: {
                        required: "Ingresa una fecha de fin.",
                    }
                },

                submitHandler: function(form) {
                    form.submit();
                },
            });
    </script>
@endsection
