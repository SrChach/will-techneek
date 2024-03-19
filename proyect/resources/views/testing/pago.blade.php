@extends('layouts.app')

@section('content')
    @php

        // SDK de Mercado Pago
        require base_path('vendor/autoload.php');
        use MercadoPago\MercadoPagoConfig;
        use MercadoPago\Client\Preference\PreferenceClient;
        // Agrega credenciales
        MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $json = file_get_contents('php://input');
        $data = json_decode($json);

        $client = new PreferenceClient();
        $preference = $client->create([
            'items' => [
                [
                    'title' => 'Poducto',
                    'quantity' => 1,
                    'currency_id' => 'MX',
                    'unit_price' => 100,
                ],
            ],
        ]);

        $preference->back_urls = array(
            'success' => 'https://techneektutor.com/sistema/pedidos/feedback',
        );
        $preference->auto_return = 'approved';

       
        //echo $preference['response']['sandbox_init_point'];

    @endphp

    @isset($respuesta)
        @php
            $respuesta = [
                'Payment' => $_GET['payment_id'],
                'Status' => $_GET['status'],
                'MerchantOrder' => $_GET['merchant_order_id'],
            ];
            echo json_encode($respuesta);
        @endphp
    @endisset

    <div class="col-12 col-md-6">
        <div class="card">
            <h2 class="card-header"><i class="mdi mdi-clipboard-check-outline"></i> Resumen de pedido</h2>
            <div class="card-body">

                <h4 class="mb-3 header-title">Prueba de pago</h4>

                <form action="#">
                    <div class="row mb-3">
                        <label for="inputEmail3" class="col-4 col-md-3 col-form-label">Horas</label>
                        <div class="d-flex col-5 col-md-4">
                            <button type="button"
                                class="btn btn-outline-danger btn-xs waves-effect waves-light"onclick="restarHoras()"><i
                                    class="mdi mdi-minus-thick"></i></button>
                            <input type="number" id="horas" name="horas" class="border-0 bg-transparent col-3"
                                form="formPago" value="1" tabindex="-1">
                            <button type="button"
                                class="btn btn-outline-success btn-xs waves-effect waves-light"onclick="sumarHoras()"><i
                                    class="mdi mdi-plus-thick"></i></button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-md-3 col-form-label">Costo por hora</label>
                        <div class="col-5 col-md-3">
                            <input type="text" id="subtotal" name="subtotal" class="form-control" value="200"
                                tabindex="-1">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-3 col-md-3 col-form-label">TOTAL</label>
                        <div class="col-5 col-md-3">
                            <input type="text" id="total" name="total" form="formPago" class="form-control"
                                value="200" tabindex="-1">
                        </div>
                    </div>
                    <div class="justify-content-end row">
                        <div class="col-8 col-xl-9">
                            <button type="submit" class="btn btn-xl font-16 btn-success" id="btn-new-event">Continuar con
                                el pago<span class="btn-label-right"><i
                                        class="mdi mdi-chevron-double-right"></i></span></button>
                            <div id="wallet_container">

                            </div>
                        </div>
                    </div>
                </form>
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
                redirectMode: "self",
            },
            callbacks: {
                onReady: () => {},
                onSubmit: () => alert('entro a mp'),
                onError: (error) => console.error(error),
            },
        });
    </script>
@endsection
