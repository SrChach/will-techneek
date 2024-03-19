"use strict";
$(document).ready(function () {
    $("#basicwizard").bootstrapWizard(),
        $("#progressbarwizard").bootstrapWizard({
            onTabShow: function (t, r, a) {
                r = ((a + 1) / r.find("li").length) * 100;
                $("#progressbarwizard")
                    .find(".bar")
                    .css({ width: r + "%" });
            },
            onNext: function (t, r, a) {
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
                    console.log('no pinta nada');
                }

            },
        }),
        $("#btnwizard").bootstrapWizard({ nextSelector: ".button-next", previousSelector: ".button-previous", firstSelector: ".button-first", lastSelector: ".button-last" }),
        $("#rootwizard").bootstrapWizard({
            onNext: function (t, r, a) {
                t = $($(t).data("targetForm"));
                if (t && (t.addClass("was-validated"), !1 === t[0].checkValidity())) return event.preventDefault(), event.stopPropagation(), !1;
            },
        });
});