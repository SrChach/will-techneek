$.ajaxSetup({
    headers:
        { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$("#formRegistro")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            correo: {
                required: true,
                email: true
            },
            nombre: {
                required: true,
            },
            apellidos: {
                required: true,
            },
            contraseña: {
                required: true,
                minlength: 8,
            },
            confirmacion: {
                required: true,
                minlength: 8,
                equalTo: "#contraseña"
            }
        },

        messages: {
            correo: {
                required: "Correo electronico requerido",
                email: "Ingrese una dirección de correo électronico válida."
            },
            nombre: {
                required: "Nombre requerido.",
            },
            apellidos: {
                required: "Apellidos requeridos.",
            },
            contraseña: {
                required: "Contraseña obligatoria.",
                minlength: "Carecteres reequeridos 8."
            },
            confirmacion: {
                required: "Se requiere confirmar su contraseña",
                minlength: "Carecteres reequeridos 8.",
                equalTo: "Las contraseñas no coinciden"
            },
        },

        submitHandler: function (form) {
            var datos = $(form).serialize();
            $("#button").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "https://techneektutor.com/sistema/register/store",
                datatype: "json",
                data: datos,
                success: function (data) {
                    console.log(data);
                    /* respuesta = JSON.parse(data);
                    console.log(respuesta); */
                    if (data.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        window.setTimeout(function () {
                            location.reload();
                        }, 3500);
                    } else if (data.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        window.setTimeout(function () {
                            location.reload();
                        }, 3500);
                    }
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    /*window.setTimeout(function () {
                      location.assign("index.php");
                    }, 3500);*/
                },
            });
            return false;
        },
    });

//? formularios del administrador
//* formulario para agregar materia
$("#formmateria")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            nombre: {
                required: true,
            },
            costo: {
                required: true,
            }
        },

        messages: {
            nombre: {
                required: "Nombre requerido.",
            },
            costo: {
                required: "Costo de la materia",
            }
        },

        submitHandler: function (form) {
            var formData = new FormData(form);

            $.ajax({
                url: "https://techneektutor.com/sistema/materia",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    respuesta = JSON.parse(data);
                    console.log(respuesta);
                    if (respuesta.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        window.setTimeout(function () {
                            location.assign("https://techneektutor.com/sistema/materia");
                        }, 3500);
                    } else if (respuesta.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        /*window.setTimeout(function () {
                          location.assign("index.php");
                        }, 3500);*/
                    }
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    /*window.setTimeout(function () {
                      location.assign("index.php");
                    }, 3500);*/
                },
            });
            return false;
        },
    });

//* formulario para agregar profesor
$("#formprofesor")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            nombre: {
                required: true,
            },
            correo: {
                required: true,
                email: true
            },
            contraseña: {
                required: true,
                minlength: 8,
            },
            confirma: {
                required: true,
                minlength: 8,
                equalTo: "#contraseña"
            }

        },

        messages: {
            nombre: {
                required: "Nombre requerido.",
            },
            correo: {
                required: "Correo requerido",
                email: "Ingrese una dirección de correo électronico válida."
            },
            contraseña: {
                required: "Contraseña obligatoria.",
                minlength: "Carecteres reequeridos 8."
            },
            confirma: {
                required: "Se requiere confirmar su contraseña",
                minlength: "Carecteres reequeridos 8.",
                equalTo: "Las contraseñas no coinciden"
            },
        },

        submitHandler: function (form) {
            var datos = $(form).serialize();
            $("#botonProfSubmit").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "https://techneektutor.com/sistema/profesor",
                datatype: "json",
                data: datos,
                success: function (data) {
                    console.log(data);
                    /* respuesta = JSON.parse(data);
                    console.log(respuesta); */
                    if (data.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        window.setTimeout(function () {
                            location.assign("https://techneektutor.com/sistema/profesor");
                        }, 3500);
                    } else if (data.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        /*window.setTimeout(function () {
                          location.assign("index.php");
                        }, 3500);*/
                    }
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                    /*window.setTimeout(function () {
                      location.assign("index.php");
                    }, 3500);*/
                },
            });
            return false;
        },
    });


//? formularios del perfil de usuario
//* formulario de datos generales
$("#formDatos")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            nombre: {
                required: true,
            },
            apellidos: {
                required: true,
            },
            telefono:
            {
                minlength: 10,
                maxlength: 10
            }

        },

        messages: {
            nombre: {
                required: "Nombre requerido.",
            },
            apellidos: {
                required: "Apellidos requeridos.",
            },
            telefono: {
                minlength: "El numero del teléfono debe tener  10 digitos",
                maxlength: "El numero del teléfono debe tener  10 digitos"
            }
        },

        submitHandler: function (form) {
            let formData = new FormData(form);
            $("#agregarhorario").prop("disabled", true);
            $.ajax({
                url: "https://techneektutor.com/sistema/perfil/datos",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    let respuesta = JSON.parse(data);
                    console.log(respuesta);
                    if (respuesta.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    } else if (respuesta.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    }
                    window.setTimeout(function () {
                        location.reload();
                    }, 3500);
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                },
            });
            return false;
        },
    });

//* formulario de cambio de contraseña
$("#formPassword")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            password: {
                required: true,
            },
            confirm_password: {
                required: true,
                equalTo: "#password"
            }
        },

        messages: {
            password: {
                required: "Contraseña nueva requerida.",
            },
            confirm_password: {
                required: "Se requiere confimar contraseña.",
                equalTo: "Las contraseñas no coinciden"
            }
        },

        submitHandler: function (form) {
            var datos = $(form).serialize();
            $("#submitPass").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "https://techneektutor.com/sistema/perfil/password", //https://techneektutor.com/sistema/perfil/horario/agregar
                datatype: "json",
                data: datos,
                success: function (data) {
                    console.log(data);
                    if (data.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    } else if (data.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    }
                    window.setTimeout(function () {
                        location.reload();
                    }, 3500);
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                },
            });
            return false;
        },
    });

//* formulario para agregar horario
$("#formHorario")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            dia: {
                required: true,
            },
            hora: {
                required: true,
            }
        },

        messages: {
            dia: {
                required: "Selecciona un día.",
            },
            hora: {
                required: "Selecciona una hora",
            }
        },

        submitHandler: function (form) {
            var datos = $(form).serialize();
            $("#agregarhorario").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "https://techneektutor.com/sistema/perfil/horario",
                datatype: "json",
                data: datos,
                success: function (data) {
                    console.log(data);
                    if (data.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    } else if (data.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: data.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                    }
                    window.setTimeout(function () {
                        location.reload();
                    }, 3500);
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                },
            });
            return false;
        },
    });

$("#formConfirmarPassword")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            password: {
                required: true,
                minlength: 8,
            },
            passwordConfirm: {
                required: true,
                minlength: 8,
                equalTo: "#password"
            }
        },

        messages: {
            password: {
                required: "Contraseña obligatoria.",
                minlength: "Carecteres reequeridos 8."
            },
            passwordConfirm: {
                required: "Se requiere confirmar su contraseña",
                minlength: "Carecteres reequeridos 8.",
                equalTo: "Las contraseñas no coinciden"
            },
        },

        submitHandler: function (form) {
            let formdata = new FormData(form)

            $.ajax({
                url: "https://techneektutor.com/sistema/cambio/password",
                type: "post",
                dataType: "html",
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    respuesta = JSON.parse(data);
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: respuesta.mensaje,
                        showConfirmButton: false,
                        timer: 3500,
                    });
                    window.setTimeout(function () {
                        location.reload();
                    }, 3500);
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                },
            });
            return false;
        },
    });

$("#formEnviarMailPassword")
    .submit(function (e) {
        e.preventDefault();
    })
    .validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },

        messages: {
            email: {
                required: "Correo requerido",
                email: "Ingrese una dirección de correo électronico válida."
            },
        },

        submitHandler: function (form) {
            let formdata = new FormData(form)

            $.ajax({
                url: "https://techneektutor.com/sistema/forgot-password",
                type: "post",
                dataType: "html",
                data: formdata,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    console.log(data);
                    respuesta = JSON.parse(data);
                    if (respuesta.estado == true) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        window.setTimeout(function () {
                            location.assign("https://techneektutor.com/sistema/login");
                        }, 3500);
                    } else if (respuesta.estado == false) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            title: respuesta.mensaje,
                            showConfirmButton: false,
                            timer: 3500,
                        });
                        window.setTimeout(function () {
                            location.reload();
                        }, 3500);
                    }
                    
                },
                error: function () {
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title: "Petición no procesada. Intentalo mas tarde,",
                        showConfirmButton: false,
                        timer: 3000,
                    });
                },
            });
            return false;
        },
    });