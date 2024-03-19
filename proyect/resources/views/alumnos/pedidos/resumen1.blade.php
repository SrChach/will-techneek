@extends('layouts.app')

@section('content')
    @php

        // SDK de Mercado Pago
        require base_path('vendor/autoload.php');
        use MercadoPago\MercadoPagoConfig;
        use MercadoPago\Client\Preference\PreferenceClient;

        // Agrega credenciales
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

        $title = 'Clases : ' . $materia->nombre;
        $quantity = intval($pedido->numero_horas);
        $unit_price = floatval($subtotal);

        $client = new PreferenceClient();

        $preference = $client->create([
            'items' => [
                [
                    'title' => $title,
                    'quantity' => $quantity,
                    'currency_id' => 'MX',
                    'unit_price' => $unit_price,
                ],
            ],
            'back_urls' => array(
                'success' => 'https://techneektutor.com/sistema/pedidos/feedback/' . $folio,
                'failure' => 'https://techneektutor.com/sistema/pedidos/feedback/' . $folio,
                'pending' => 'https://techneektutor.com/sistema/pedidos/feedback/' . $folio,
            ),
            'auto_return' => 'approved',
            'payment_methods' => [
                'excluded_payment_methods' => [],
                'excluded_payment_types' => [
                    [
                        'id' => 'bank_transfer',
                    ],
                    [
                        'id' => 'ticket',
                    ],
                ],
                'installments' => 1,
            ],
        ]);
    @endphp
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">

                <div class="panel-body">
                    <div class="clearfix">
                        <div class="float-start">
                            <img src="https://techneektutor.com/sistema/assets/images/techneek_white.svg" alt="logo">
                        </div>
                        <div class="float-end">
                            <h4><strong>{{ $folio }}</strong></h4>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="float-start mt-3">
                                <address>
                                    <strong> {{ Auth::user()->nombre . ' ' . Auth::user()->apellidos }} </strong><br>
                                    {{ Auth::user()->email }} <br>
                                    @isset(Auth::user()->telefono)
                                        <abbr title="Phone">Tel:</abbr> {{ Auth::user()->telefono }}
                                    @endisset
                                </address>
                            </div>
                            <div class="float-end mt-3">
                                <p><strong>Fecha de Pedido: </strong>
                                    {{ $formatoFecha['diaMes'] . ' ' . $infoMes['nombreMes'] }} @php date('Y') @endphp </p>
                                <p class="m-t-10"><strong>Estado: </strong><span class="label label-pink">Pendiente de
                                        Pago</span></p>
                            </div>
                        </div><!-- end col -->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table mt-4">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Descripción</th>
                                            <th>Cantidad</th>
                                            <th>Costo Unitario</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td> Clases : {{ $materia->nombre }} </td>
                                            <td> {{ $pedido->numero_horas }} </td>
                                            <td> {{ $subtotal }} </td>
                                            <td> {{ $pedido->total }} </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-6">
                        </div>
                        <div class="col-xl-3 col-6 offset-xl-3">
                            <p class="text-end"><b>Sub-total:</b> {{ $pedido->total }} </p>
                            <hr>
                            <h3 class="text-end">{{ '$' . $pedido->total . ' MXN' }}</h3>
                        </div>
                    </div>
                    <hr>
                    <div class="d-print-none">
                        <div class="float-end">
                            <a href="javascript:window.print()" class="btn btn-dark waves-effect waves-light"><i
                                    class="fa fa-print"></i></a>
                            <div id="wallet_container"></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>
        const mp = new MercadoPago('{{ config('services.mercadopago.key') }}');
        const bricksBuilder = mp.bricks();


        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: "{{ $preference->id }}",
                redirectMode: "modal",
            },
            callbacks: {
                onReady: () => {},
                onSubmit: () => {},
                onError: (error) => console.error(error),
            },
        });
    </script>
@endsection
