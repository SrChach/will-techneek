@extends('layouts.guest')

@section('content')
    <div class="text-center mb-3">
        <a href="index.html">
            <img src="assets/images/techneek_white.svg" alt="" height="70" class="mx-auto">
        </a>
    </div>
    <div class="card">
        <div class="card-body p-4">
            <div class="text-center mb-4">
                <h4 class="text-uppercase mt-0">Olvide mi contraseña</h4>
            </div>
            @isset($mensaje)
                Se ha enviado un correo a tu dirección con tu link de recuperación
            @endisset
            <p>
                Ingrese su correo para recuperar su contraseña.
            </p>
            <form id="formEnviarMailPassword">
                @csrf
                <div class="mb-3">
                    <input class="form-control" type="email" id="email" name="email" placeholder="Correo" required>
                </div>

                <div class="mb-3 d-grid text-center">
                    <button class="btn btn-primary rounded-pill" type="submit"> Mandar enlace de recuperación </button>
                </div>
            </form>

        </div> <!-- end card-body -->
    </div>
    <!-- end card -->

    <div class="row mt-3">
        <div class="col-12 text-center">

        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection
