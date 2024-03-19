@extends('layouts.app')

@section('content')
    <div class="col-12">
        <div class="card">
            <h4 class="card-header"><i class="mdi mdi-desk-lamp"></i> Mis clases</h4>
            <div class="card-body">
                <input class="d-none" id="idMateria" name="idMateria" type="text" value="{{ $idMateria }}">
                <form id="formWizard">
                    @csrf
                    <div id="progressbarwizard">

                        <ul class="nav nav-pills bg-light nav-justified form-wizard-header mb-3">
                            <li class="nav-item">
                                <a href="#account-2" data-bs-toggle="tab" data-toggle="tab"
                                    class="nav-link rounded-0 pt-2 pb-2" @disabled(true)>
                                    <i class="mdi mdi-calendar-search me-1"></i>
                                    <span class="d-none d-sm-inline">Seleccionar Fecha</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile-tab-2" data-bs-toggle="tab" data-toggle="tab"
                                    class="nav-link rounded-0 pt-2 pb-2" @disabled(true)>
                                    <i class="mdi mdi-teach me-1"></i>
                                    <span class="d-none d-sm-inline">Seleccionar Profesor</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#finish-2" data-bs-toggle="tab" data-toggle="tab"
                                    class="nav-link rounded-0 pt-2 pb-2" @disabled(true)>
                                    <i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>
                                    <span class="d-none d-sm-inline">Finalizar</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content b-0 mb-0 pt-0">

                            <div id="bar" class="progress mb-3" style="height: 7px;">
                                <div class="bar progress-bar progress-bar-striped progress-bar-animated bg-success"></div>
                            </div>

                            <div class="tab-pane" id="account-2">
                                <div class="row mb-3">
                                    <div class="col-md-6 col-lg-6">
                                        <label class="form-label">Seleccione la fecha</label>
                                        <input type="text" id="inline-datepicker" name="fecha"
                                            class="form-control d-none" minDate = "{{ date('Y-m-d') }}"
                                            placeholder="Inline calendar">
                                    </div>
                                    <div class="col-md-6 col-lg-6" id="horarios">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="profile-tab-2">
                                <div class="row py-3" id="profesores">

                                </div> <!-- end row -->
                            </div>

                            <div class="tab-pane" id="finish-2">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-center">
                                            <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                            <h3 class="mt-0">¡Confirmación!</h3>
                                            <p class="w-75 mb-2 mx-auto">
                                                ¿Estás seguro de los datos introducidos? Una vez finalizado el proceso
                                                se generará una liga de reunión de meets con la fecha y hora establecidos
                                                para impartir tu clase.
                                            </p>
                                            <button type="submit"
                                                class="btn btn-outline-success rounded-pill waves-effect waves-light">Programar
                                                Clase</button>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->
                            </div>

                            <ul class="list-inline mb-0 wizard">
                                <li class="previous list-inline-item">
                                    <a href="javascript: void(0);" class="btn btn-secondary">Atras</a>
                                </li>
                                <li class="next list-inline-item float-end">
                                    <a href="javascript: void(0);" class="btn btn-secondary">Siguiente</a>
                                </li>
                            </ul>

                        </div> <!-- tab-content -->
                    </div> <!-- end #progressbarwizard-->
                </form>

                <input type="text" name="respuesta" id="respuesta" value="" hidden>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-wizard.init.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-pickers.init.js') }}"></script>

    <script type="text/javascript">
        /* exported gapiLoaded */
        /* exported gisLoaded */
        /* exported handleAuthClick */
        /* exported handleSignoutClick */

        // TODO(developer): Set to client ID and API key from the Developer Console
        const CLIENT_ID = '835510703416-bbphdnffsthhvgnfq4s2pgj51aslqrih.apps.googleusercontent.com';
        // TODO nacho CHECK calendar API key
        const API_KEY = "<?php echo env('CALENDAR_PROGRAMACION_API_KEY', ''); ?>";

        // Discovery doc URL for APIs used by the quickstart
        const DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/calendar/v3/rest';

        // Authorization scopes required by the API; multiple scopes can be
        // included, separated by spaces.
        const SCOPES = 'https://www.googleapis.com/auth/calendar'; 
        //const SCOPES = 'https://accounts.google.com/o/oauth2/auth?scope=%s&redirect_uri=%s&response_type=code&client_id=%s&access_type=online';

        let tokenClient;
        let gapiInited = false;
        let gisInited = false;
        let idClase;
        let correoProfesor;
        let fechaFinal;
        let fechaIncio;
        let formatoFechaFin;
        let formatoFechaInicio;
        let nombreMateria;

        /* 
                document.getElementById('authorize_button').style.visibility = 'hidden';
                document.getElementById('signout_button').style.visibility = 'hidden';
         */
        /**
         * Callback after api.js is loaded.
         */
        function gapiLoaded() {
            gapi.load('client', initializeGapiClient);
        }

        /**
         * Callback after the API client is loaded. Loads the
         * discovery doc to initialize the API.
         */
        async function initializeGapiClient() {
            await gapi.client.init({
                apiKey: API_KEY,
                discoveryDocs: [DISCOVERY_DOC],
            });
            gapiInited = true;
            maybeEnableButtons();
        }

        /**
         * Callback after Google Identity Services are loaded.
         */
        function gisLoaded() {
            tokenClient = google.accounts.oauth2.initTokenClient({
                client_id: CLIENT_ID,
                scope: SCOPES,
                callback: '', // defined later
            });
            gisInited = true;
            maybeEnableButtons();
        }

        /**
         * Enables user interaction after all libraries are loaded.
         */
        function maybeEnableButtons() {
            if (gapiInited && gisInited) {
                //document.getElementById('authorize_button').style.visibility = 'visible';
                console.log('se logeo bien');
            }
        }

        /**
         *  Sign in the user upon button click.
         */
        function handleAuthClick() {
            tokenClient.callback = async (resp) => {
                if (resp.error !== undefined) {
                    throw (resp);
                }
                //document.getElementById('signout_button').style.visibility = 'visible';
                //document.getElementById('authorize_button').innerText = 'Refresh';

                await insertEventRandom();
            };

            if (gapi.client.getToken() === null) {
                // Prompt the user to select a Google Account and ask for consent to share their data
                // when establishing a new session.
                tokenClient.requestAccessToken({
                    prompt: 'consent'
                });
            } else {
                // Skip display of account chooser and consent dialog for an existing session.
                tokenClient.requestAccessToken({
                    prompt: ''
                });
            }
        }

        /**
         *  Sign out the user upon button click.
         */
        function handleSignoutClick() {
            const token = gapi.client.getToken();
            if (token !== null) {
                google.accounts.oauth2.revoke(token.access_token);
                gapi.client.setToken('');
                //document.getElementById('content').innerText = '';
                //document.getElementById('authorize_button').innerText = 'Authorize';
                //document.getElementById('signout_button').style.visibility = 'hidden';
            }
        }

        async function insertEventRandom() {
            // Refer to the JavaScript quickstart on how to setup the environment:
            // https://developers.google.com/calendar/quickstart/js
            // Change the scope to 'https://www.googleapis.com/auth/calendar' and delete any
            // stored credentials.

            const event = {
                'summary': 'Clase ' + idClase + ' ' + nombreMateria,
                'location': 'Virtual',
                'description': 'Clase ' + idClase + ' ' + nombreMateria,
                'start': {
                    'dateTime': formatoFechaInicio,
                    'timeZone': 'America/Mexico_City'
                },
                'end': {
                    'dateTime': formatoFechaFin,
                    'timeZone': 'America/Mexico_City',
                },
                'attendees': [{
                    'email': correoProfesor,                    
                },
                {
                    'email': "webmaster@techneektutor.com",                    
                }],
                'reminders': {
                    'useDefault': false,
                    'overrides': [{
                            'method': 'email',
                            'minutes': 24 * 60
                        },
                        {
                            'method': 'popup',
                            'minutes': 10
                        }
                    ]
                }
            };

            console.log(event);

            const request = gapi.client.calendar.events.insert({
                'calendarId': 'primary',
                'resource': event
            });

            request.execute(function(event) {
                console.log(event);
                const eventPatch = {
                    conferenceData: {
                        createRequest: {
                            requestId: "7qxalsvy0e"
                        }
                    }
                };

                gapi.client.calendar.events.patch({
                    calendarId: "primary",
                    eventId: event.id,
                    resource: eventPatch,
                    sendNotifications: true,
                    conferenceDataVersion: 1
                }).execute(function(event) {
                    console.log(event);
                    let formdata = new FormData(document.getElementById('formWizard'));
                    let linkConference = event.hangoutLink;
                    formdata.append('linkConference', linkConference);
                    console.log(linkConference);
                    let idClase = "{{ $idClase }}";
                    let ruta = "https://techneektutor.com/sistema/clases/alumno/" + idClase +
                        "/programar";
                    console.log(ruta);

                    Swal.fire({
                        position: "center",
                        icon: "info",
                        title: "Creando clase",
                        showConfirmButton: false,
                        timer: 3000,
                    });


                    $.ajax({
                        url: ruta,
                        type: "post",
                        dataType: "html",
                        data: formdata,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            console.log(data);
                            let infoDatos = JSON.parse(data);
                            let urlFinal =
                                "https://techneektutor.com/sistema/clases/create/" +
                                infoDatos.idClase + "/" + infoDatos.idProfesor + "/" +
                                infoDatos.idAlumno + "";
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: infoDatos.mensaje,
                                showConfirmButton: false,
                                timer: 3500,
                            });
                            window.setTimeout(function() {
                                $(location).attr('href', urlFinal)
                            }, 3500);
                        },
                        error: function() {
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "Petición no procesada. Intentalo más tarde.",
                                showConfirmButton: false,
                                timer: 3000,
                            });
                        },
                    });
                });
            });


        }


        function getInfoData(formdata) {
            //console.log('hola');
            $.ajax({
                url: "https://techneektutor.com/sistema/clases/alumnno/informacion",
                type: "post",
                dataType: "html",
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    datos = JSON.parse(data);
                    console.log(datos);
                    idClase = datos.idClase;
                    nombreMateria = datos.nombreMateria;
                    formatoFechaInicio = datos.formatoFechaInicio;
                    formatoFechaFin = datos.formatoFechaFin;
                    correoProfesor = datos.correoProfesor;
                    //envioData.setData();
                    //$('#respuesta').val(data);
                    //document.getElementById('respuesta').value = data;
                },
                error: function() {
                    console.log('error');
                },
            });

        }
    </script>

    <script async defer src="https://apis.google.com/js/api.js" onload="gapiLoaded()"></script>
    <script async defer src="https://accounts.google.com/gsi/client" onload="gisLoaded()"></script>

    <script>
        $("input[name=horarios]").click(function() {
            alert('Evento click sobre un input text con nombre="nombre1"');
        });
        //* agrega select
        $('#inline-datepicker').change(function() {
            let formData = new FormData();
            let fecha = $('#inline-datepicker').val();

            formData.append('fecha', fecha);

            $.ajax({
                url: "https://techneektutor.com/sistema/horarios/dia", //https://techneektutor.com/sistema/perfil/horario/agregar
                type: "POST",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#horarios').empty();
                    console.log(data);
                    let datos = JSON.parse(data);
                    console.log(datos);
                    let horarios = datos.horariosDisponibles;
                    if (datos.estado == true) {
                        let cont = 0;
                        horarios.forEach(element => {
                            console.log(element);
                            cont = cont + 1;
                            $('#horarios').append(
                                `
                                <div class="form-check horarios-clases" style="padding: 1em 3em; border: 1px solid #676767; width: 35%; border-radius: 11px; margin: 10px 0px;">
                                    <input onclick="limpiarSelectorProfesor()" type="radio" id="customRadio${cont}" name="horarios" class="form-check-input" value="${element.hora_inicio}-${element.hora_final}">
                                    <label class="form-check-label" style="font-size: 1.2em!important;
                                    line-height: 1.2em;" for="customRadio${cont}">${element.hora_inicio} - ${element.hora_final}</label>
                                </div>
                                `
                            );
                        });
                    } else {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "No hay horarios disponibles en la fecha seleccionada, intenta de nuevo.",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo más tarde.",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                },
            });
        });

        $("#formWizard")
            .submit(function(e) {
                e.preventDefault();
            })
            .validate({
                submitHandler: function(form) {
                    let formdata = new FormData(form);
                    let idClase = "{{ $idClase }}";
                    let idMateria = "{{ $idMateria }}";
                    formdata.append('idClase', idClase);
                    formdata.append('idMateria', idMateria);
                    var formularios = $("#formWizard").serializeArray();
                    console.log($('.form-check-input:checked[type=checkbox]').val());
                    console.log(formularios);
                    console.log(formdata.get('profesores'));
                    getInfoData(formdata);
                    //let datos = document.getElementById('respuesta').value;
                    //console.log(datos);
                    //let infoDatos = JSON.parse(datos);
                    //console.log(infoDatos);  
                    handleAuthClick()
                },
            });

        function limpiarSelectorProfesor() {
            $("div").remove(".col-profesor");
            let fecha = $('#inline-datepicker').val();
            console.log(fecha);
            let horarios = $('input:radio[name=horarios]:checked').val();
            console.log(horarios);
            let profesores = $('input[name=profesores]:checked').val();
            console.log(profesores);

            let fromData = new FormData();
            fromData.append('fecha', fecha);
            fromData.append('horarios', horarios);

            if (fecha === '' || fecha == null) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Fecha obligatoria",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return false;
            } else if (horarios == undefined || horarios == null || horarios == '') {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "Selecciona un horario valido",
                    showConfirmButton: false,
                    timer: 3000,
                });
                return false;
            } else {
                $.ajax({
                    url: "https://techneektutor.com/sistema/profesores/buscar",
                    type: "POST",
                    dataType: "html",
                    data: fromData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        //$('#profesores').empty();
                        console.log(data);
                        let listProfesores = JSON.parse(data);
                        let cont = 0;
                        listProfesores.forEach(elemento => {
                            cont = cont + 1;
                            $('#profesores').append(
                                `
                                    <div class="col-12 col-md-4 col-lg-4 col-profesor">
                                        <div class="card">
                                            <div class="card-body widget-user" style="border: 1px solid #5d5d5d; border-radius: 23px;">
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle avatar-xl img-thumbnail me-3 flex-shrink-0">
                                                        <img src="${elemento.foto}" class="img-fluid rounded-circle" alt="user">
                                                    </div>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <h5 class="mt-0 mb-1">${elemento.nombre}</h5>
                                                        <p class="text-muted mb-2 font-13 text-truncate">${elemento.correo}</p>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" id="customCheck${cont}" name="profesores" value="${elemento.idUsuario}">
                                                            <label class="form-check-label" for="customCheck${cont}">Seleccionar profesor</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `
                            );
                        });
                    },
                    error: function() {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: "Petición no procesada. Intentalo mas tarde,",
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    },
                });
            }

        }
    </script>
@endsection
