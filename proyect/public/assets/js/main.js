
document.addEventListener('DOMContentLoaded', function () {
  var calendarEl = document.getElementById('calendar');
  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'resourceTimelineWeek'
  });
  calendar.render();
});



function añadirTema() {
  console.log('añadir grupo');
  let tblHorarios = document.getElementById('tableTemario').insertRow();
  let col1 = tblHorarios.insertCell(0);
  let col2 = tblHorarios.insertCell(1);
  let col3 = tblHorarios.insertCell(2);

  col1.innerHTML =
    ` 
    <input type="text" id="numero" name="numero[]"
    class="form-control" placeholder="Número">
    `;
  col2.innerHTML =
    ` 
    <input type="text" id="tituolo" name="titulo[]" class="form-control" placeholder="Tema">
    `;
  col3.innerHTML =
    `
      <button type="button"class="btn btn-outline-success rounded-pill waves-effect waves-light add" onclick="añadirTema()"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-outline-danger rounded-pill waves-effect waves-light subtract button_eliminar_tema"><i class="mdi mdi-trash-can"></i></button>
    `;
}

$('#tableTemario').on('click', '.button_eliminar_tema', function () {
  $(this).parents('tr').eq(0).remove();
});

function añadirHorario() {
  let tblHorarios = document.getElementById('tableHorario').insertRow();
  let col1 = tblHorarios.insertCell(0);
  let col2 = tblHorarios.insertCell(1);
  let col3 = tblHorarios.insertCell(2);
  $.ajax({
    type: "GET",
    url: "days",
    datatype: "json",
    success: function (data) {
      console.log(data);
      let opciones = ``;
      for (const element of data) {
        opciones = opciones + `<option value="${element.id}">${element.nombre}</option>`;
      }
      col1.innerHTML =
        `
        <select class="form-control" data-toggle="select2" data-width="100%"
            id="diaSemana" name="diaSemana[]">
            <option selected disabled>Dia</option>
            ${opciones}
        </select>
        `;
    },
    error: function () {
      console.log('error');
    },
  });

  $.ajax({
    type: "GET",
    url: "days",
    datatype: "json",
    success: function (data) {
      console.log(data);
      let opciones = ``;
      for (const element of data) {
        opciones = opciones + `<option value="${element.id}">${element.nombre}</option>`;
      }
      col2.innerHTML =
        ` 
        <select class="form-control" data-toggle="select2" data-width="100%"
        id="diaSemana" name="diaSemana[]">
        <option selected disabled>Dia</option>
        ${opciones}
        </select>
        `;
    },
    error: function () {
      console.log('error');
    },
  });


  col3.innerHTML =
    `
      <button type="button"
      class="btn btn-outline-success rounded-pill waves-effect waves-light add"
      onclick="añadirHorario()"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-outline-danger rounded-pill waves-effect waves-light subtract button_eliminar_producto" onclick="elminarHorario()"><i class="mdi mdi-trash-can-outline"></i></button>
    `;
}

$('#tableHorario').on('click', '.button_eliminar_producto', function () {
  $(this).parents('tr').eq(0).remove();
});

$("#fileAvatar").change(function () {
  let formData = new FormData(document.getElementById("formAvatar"));
  let avatar = $('#fileAvatar').val();
  formData.append('avatar', avatar);
  console.log(formData);
  $.ajax({
    url: "https://techneektutor.com/sistema/perfil/avatar",
    type: "post",
    dataType: "html",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      console.log(data);
      Swal.fire({
        position: "center",
        icon: "success",
        title: "Tu imagen ha sido actualizada.",
        showConfirmButton: true,
        timer: 2500,
      });
      //window.location.reload();
    },
    error: function (request, error) {
      console.log("Request: " + JSON.stringify(request));
    },
  });

  //console.log(img_destino);
  /* if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      //$("#imagen").attr("src", e.target.result);
      $("#imagen").css("background-image", "url(" + e.target.result + ")");
    };
    reader.readAsDataURL(input.files[0]);
  } */

});



$('.overlay').on('click', function () {

});

$("#avatarMateria").change(function () {
  console.log('hola');
  leerImgAvatar(this, document.getElementById("avatarMateria"));
});

function leerImgAvatar(input, img_destino) {
  var formData = new FormData(document.getElementById("formAvatarMateria"));
  console.log('update avatar');
  /*$.ajax({
    url: "file/avatar",
    type: "post",
    dataType: "html",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      console.log(data);
      Swal.fire({
        position: "center",
        icon: "success",
        title: "Tu imagen ha sido actualizada.",
        showConfirmButton: true,
        timer: 2500,
      });
      window.location.reload();
    },
    error: function (request, error) {
      console.log("Request: " + JSON.stringify(request));
    },
  });*/

  //console.log(avatarMateria);
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      //$("#imagen").attr("src", e.target.result);
      $("#imagen").css("background-image", "url(" + e.target.result + ")");
    };
    reader.readAsDataURL(input.files[0]);
  }
}

$.ajaxSetup({
  headers:
    { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});

$('.selectMateria').on('click', function () {
  let idmateria = $(this).val();
  let formData = new FormData();
  formData.append('idMateria', idmateria);
  let url = ``;
  if ($(this).is(':checked')) {
    //? Agregar relacion entre la materia y el usuario
    url = `https://techneektutor.com/sistema/perfil/materia`;
  } else {
    //! Eiminar relacion entre la materia y el usuario
    url = `https://techneektutor.com/sistema/perfil/materia/delete`;
  }

  $.ajax({
    url: url,
    type: "post",
    dataType: "html",
    data: formData,
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
        showConfirmButton: true,
        timer: 2500,
      });

    },
    error: function (request, error) {
      console.log("Request: " + JSON.stringify(request));
    },
  });
});

function sumarHoras() {
  let numero = $('#horas').val();
  let precio = $('#subtotal').val();
  let total = $('#total').val();

  numero = parseInt(numero) + 1;

  precio = parseInt(numero) * parseInt(precio);
  total = precio;

  $('#horas').val(numero);
  $('#horasform').val(numero);
  $('#total').val(total);
}

function restarHoras() {
  let numero = $('#horas').val();
  let precio = $('#subtotal').val();
  let total = $('#total').val();

  if (numero == parseInt(1)) {
    Swal.fire({
      position: "center",
      icon: "error",
      title: "El numero de horas no puede ser menor a 1.",
      showConfirmButton: true,
      timer: 2500,
    });
  } else {
    numero = parseInt(numero) - 1;
  }

  precio = parseInt(numero) * parseInt(precio);
  total = precio;

  $('#horas').val(numero);
  $('#horasform').val(numero);
  $('#total').val(total);
}

function suspender(id) {
  Swal.fire({
    title: 'Seguro que quieres suspender a este usuario',
    showDenyButton: true,
    confirmButtonText: 'Suspender',
    denyButtonText: `Cancelar`,
  }).then((result) => {
    /* Read more about isConfirmed, isDenied below */
    if (result.isConfirmed) {
      let idUsuario = id;

      $.ajax({
        type: "get",
        url: "https://techneektutor.com/sistema/usuario/" + idUsuario + "/suspender",
        datatype: "json",
        success: function (data) {
          console.log(data);
          Swal.fire({
            position: "center",
            icon: "warning",
            title: data.mensaje,
            showConfirmButton: false,
            timer: 3500,
          });
          window.setTimeout(function () {
            location.reload();
          }, 3500);
        },
        error: function () {
          console.log('error');
        },
      });

    } else if (result.isDenied) {
      Swal.fire('Petición cancelada', '', 'info')
    }
  })
}

function activar(id) {
  $.ajax({
    type: "get",
    url: "https://techneektutor.com/sistema/usuario/" + id + "/activar",
    datatype: "json",
    success: function (data) {
      console.log(data);
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
    },
    error: function () {
      console.log('error');
    },
  });
}