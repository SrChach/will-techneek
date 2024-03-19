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
                <h4 class="text-uppercase mt-0">Iniciar Sesión</h4>
            </div>

            <form action=" {{ route('login') }} " method="POST">
                @csrf
                <div class="mb-3">
                    <input class="form-control" type="email" id="email" name="email" placeholder="Correo" required>
                </div>

                <div class="mb-3">
                    <input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>
                </div>

                <div class="mb-3 d-grid text-center">
                    <button class="btn btn-primary rounded-pill" type="submit"> Iniciar Sesión </button>
                    <a href="{{ route('google.redirect') }}" class="btn btn-primary rounded-pill waves-effect waves-light mt-2">
                        <span class="btn-label"><i class="fab fa-google"></i></span>Inicia con Google
                    </a>
                </div>
                <div class="mb-3 d-grid text-center">
                                <p class="text-dark "><a href="{{ route('register') }}" class="ms-1 text-dark "><b>Registrarse</b></a></p>
            <p> <a href="{{ route('forgotPassword.get') }}" class="text-dark ms-1"><i class="text-dark fa fa-lock me-1"></i>Olvidé mi
                    contraseña?</a></p>
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
