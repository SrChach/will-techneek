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
                <h4 class="text-uppercase mt-0">Cambiar contraseña</h4>
            </div>
            <p>

            </p>
            <form id="formConfirmarPassword">
                @csrf
                <div class="mb-3">
                    <input class="form-control" type="password" id="password" name="password"
                        placeholder="Contraseña Nueva" required>
                </div>
                <div class="mb-3">
                    <input class="form-control" type="password" id="passwordConfirm" name="passwordConfirm"
                        placeholder="Confirmar contraseña nueva" required>
                </div>
                <input type="text" name="idUsuario" id="idUsuario" value="{{ $id }}" style="display: none;">
                <input type="text" name="token" id="token" value="{{ $token }}" style="display: none;">
                <div class="mb-3 d-grid text-center">
                    <button class="btn btn-primary rounded-pill" type="submit">
                        Enviar
                    </button>
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

