@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h2 class="card-header"><i class="mdi mdi-clipboard-check-outline"></i> Mis pedidos</h2>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Folio</th>
                                <th>Materia</th>
                                <th>Horas</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pedidos as $pedido)
                                <tr>
                                    <th scope="row"> {{ $pedido->folio }} </th>
                                    <td> {{ $pedido->materia }} </td>
                                    <td> {{ $pedido->horas }} </td>
                                    <td>
                                        <span class="badge badge-outline-{{ $pedido->etiqueta }} rounded-pill">
                                            {{ $pedido->estado }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($pedido->idEstados == 1)
                                            <a href=" {{ route('pedido.resumen', $pedido->folio) }} "
                                                class="btn btn-sm btn-outline-warning rounded-pill waves-effect waves-light">
                                                Continuar con el pago
                                            </a>
                                        @elseif ($pedido->idEstados == 2)
                                            <a href=" {{ route('pedidos.show', $pedido->folio) }} "
                                                class="btn btn-sm btn-outline-primary rounded-pill waves-effect waves-light">
                                                Detalles
                                            </a>
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
@endsection
