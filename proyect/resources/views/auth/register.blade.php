@extends('layouts.guest')

@section('content')
<script type="text/javascript" src="https://fasoluciones.mx/js/jquery.js"></script>

<script type="text/javascript">
$(document).ready(function() {
	$('#correo').change(function(){
		var Buscador = $(this).val();
		var dataString = 'CorreoVerificar='+Buscador;

		$.ajax({
			type: "GET",
			url: "{{route('register.verificarCorreo')}}",
			data: dataString,
			success: function(data) {
				if(data=="Existe"){
					$('#PrincipalCorreoVerificar').html('<div id="MensajeValidarCorreo"><div class="alert alert-warning" role="alert">El correo ya está registrado</div></div>');
					$("#BloquearBoton").attr('disabled','disabled');
				}
				else{
					$('#PrincipalCorreoVerificar').html('');
					$('#BloquearBoton').removeAttr("disabled");

				}
			}
		});
	});
});
</script>

    <div class="text-center mb-3">
        <a href="index.html">
            <img src="assets/images/techneek_white.svg" alt="" height="70" class="mx-auto">
        </a>
        <!--<p class="text-muted mt-2 mb-4">Responsive Admin Dashboard</p>-->
    </div>
    <div class="card">

        <div class="card-body p-4">

            <div class="text-center mb-4">
                <h4 class="text-uppercase mt-0">Nuevo Alumno</h4>
                <p> Llena tus datos para registrarte</p>
            </div>

            <form id="formRegistro">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo"
                            required>
                            
                            
						
                        <div id="PrincipalCorreoVerificar">
                        </div>
                        
                    </div>
                    <div class="col-md-6 mb-3">
                        <input class="form-control" maxlength="20" type="text" id="nombre" name="nombre" required
                            placeholder="Nombre" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <input class="form-control" maxlength="20" type="text" id="apellidos" name="apellidos"
                            placeholder="Apellido" required>
                    </div>
                    <div class="col-md-6 mb-3">
                       <!-- <input class="form-control" maxlength="15" type="password" id="contraseña" name="contraseña"
                            placeholder="Contraseña" required>-->
                        <div class="input-group input-group-merge">
                            <input type="password" class="form-control"  maxlength="15"  id="contraseña" name="contraseña"
                            placeholder="Contraseña" required>
                            <br>
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <!--<input class="form-control" maxlength="15" type="password" id="confirmacion" name="confirmacion"
                            placeholder="Confirmar Contraseña">-->

                        <div class="input-group input-group-merge">
                            <input class="form-control" maxlength="15" type="password" id="confirmacion" name="confirmacion"
                            placeholder="Confirmar Contraseña" required>
                            
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                            </div>
                    </div>

                    <div class="col-12 col-md-12 mt-3">
                        <h4 class="header-title mt-3 mt-md-0">Materias que me interesan</h4>
                    </div>
                    @foreach ($listmaterias as $materia)
                        <div class="col-md-3 mb-3">
                            <div class="form-check mb-2 form-check-primary">
                                <input class="form-check-input rounded-circle" type="checkbox" value=" {{ $materia->id }} "
                                    id="select{{ $materia->id }}" name="materias[]">
                                <label class="form-check-label" for="select{{ $materia->id }}"> {{ $materia->nombre }} </label>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mb-3 text-center d-grid">
                    <button class="btn btn-primary" type="submit" id="BloquearBoton"> Enviar </button>
                    <a href="{{ route('google.redirect') }}" class="btn btn-primary rounded-pill waves-effect waves-light mt-2">
                        <span class="btn-label"><i class="fab fa-google"></i></span>Inicia con Google
                    </a>
                </div>
            </form>

        </div> <!-- end card-body -->
    </div>
@endsection