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
            <h2 class="card-header">Clases</h2>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <form id="formFiltre" class="d-flex flex-wrap align-items-center justify-content-sm-end" method="POST"
                            action="{{ route('filtro', 0) }}">
                            @csrf
                            <label for="status-select" class="me-2">Estado de la clase</label>
                            <div class="me-sm-2">
                                <select class="form-select my-1 my-md-0" id="estado" name="estado">
                                    @foreach ($estados as $estado)
                                        @if ($estado->id > 1)
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
            <div class="card-body p-2">
                <div class="table-responsive">
                    <table id="listItems" class="table mb-0">
                        <thead>
                            <tr>
                                <th>ID CLASE</th>
                                <th>MATERIA</th>
                                <th>PROFESOR</th>
                                <th>ALUMNO</th>
                                <th>FECHA - HORA</th>
                                <th>ESTADO</th>
                                <th>PAGO</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($listClases as $clase)
                                <tr>
                                    <th scope="row"> {{ $clase['idClase'] }} </th>
                                    <td class="text-info"><a
                                            href=" {{ route('materia.show', $clase['idMateria']) }} "><strong>
                                                {{ $clase['nombreMateria'] }} </strong></a></td>
                                    <td class="text-info"><a href="#"><strong> {{ $clase['nombreProfesor'] }}
                                            </strong></a></td>
                                    <td class="text-info"><a
                                            href=" {{ route('alumno.show', $clase['idAlumno']) }} "><strong>
                                                {{ $clase['nombreAlumno'] }} </strong></a></td>
                                    <td>
                                    
                                        @isset($clase['fechaClase'])
                                            {{ date('d-m-Y', strtotime($clase['fechaClase'])) }}
                                            {{ date('h:s a', strtotime($clase['horaClase'])) }}
                                        @endisset
                                    </td>
                                    <td>
                                    
                                    <?php 
									/*echo "<pre>";
									print_r($clase);
									echo "</pre>";*/
									?>
                                    
                                    
                                    <span class="badge bg-{{ $clase['etiqueta'] }} rounded-pill">
                                            {{ $clase['estado'] }} </span></td>
                                            
                                    <td class="text-info">
                                    
                                        <?php $arraysumando[] = $clase['pago']; ?>
                                        {{ number_format($clase['pago'], 2) }}
                                    </td>        
                                    <td>
                                        @if ($clase['idEstado'] >= 2)
                                            <a href=" {{ route('ficha.show', $clase['idClase']) }} "
                                                class="btn btn-outline-primary rounded-pill waves-effect waves-light">Detalles</a>
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
                <h4>Total $<?php if(isset($arraysumando))echo number_format(array_sum($arraysumando), 2); ?></h4>
            </div>
        </div>
    </div>
    <!-- Acaba Totales -->
@endsection

@section('scripts')
    <<script src="{{ asset('assets/js/tableinit.js') }}"></script>
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
