<div class="row">
    <div class="col-12 col-md-12">
        <div class="card">
            <h5 class="card-header"><i class="mdi mdi-teach me-1"></i> Profesores</h5>
            <div class="card-body">
                @if (sizeof($infoProfesores) > 0)
                    @foreach ($infoProfesores as $profesor)
                        <ul class="list-group mb-0 user-list">
                            <li class="list-group-item">
                                <a href="{{ route('profesor.alumno.ficha',  $profesor->id_use) }}" class="user-list-item">
                                    <div class="user avatar-sm float-start me-2">
                                        <img src="{{ $profesor->fotoUsuario }}" alt=""
                                            class="img-fluid rounded-circle">
                                    </div>
                                    <div class="user-desc">
                                        <h5 class="name mt-0 mb-1"> {{ $profesor->nombreUsuario }} {{ $profesor->apellidosUsuario }} </h5>
                                        <p class="desc text-muted mb-0 font-12"> {{{ $profesor->emailUsuario }}} </p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                @else
                    <p class="text-muted text-center">
                        <i style="font-size: 70px;" class="mdi mdi-emoticon-confused-outline"></i>
                    </p>
                    <h5 class="text-muted">No encontramos nada por aquí</h5>
                @endif

            </div>
        </div>
    </div>
</div> 