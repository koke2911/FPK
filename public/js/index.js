


function enviarFormulario(){

    var txt_nombre = $("#txt_nombre").val();
    var txt_rut = $("#txt_rut").val();
    var dt_nacimiento = $("#dt_nacimiento").val();
    var txt_email = $("#txt_email").val();
    var txt_fono = $("#txt_fono").val();
    var cmb_region = $("#cmb_region").val();
    var cmb_comuna = $("#cmb_comuna").val();
    var txt_sector = $("#txt_sector").val();

    var data = {
        txt_nombre:txt_nombre,
        txt_rut:txt_rut,
        dt_nacimiento:dt_nacimiento,
        txt_email:txt_email,
        txt_fono:txt_fono,
        cmb_region:cmb_region,
        cmb_comuna:cmb_comuna,
        txt_sector: txt_sector
    };

    $.ajax({
        type: 'POST',
        url: 'model/envia_contacto.php',
        data: data,
        dataType: 'json',
        success: function (data) {
            if (data.codigo == 2) {
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    text: data.mensaje,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            } else {
                Swal.fire({
                    title: 'Estaremos en contacto!',
                    icon: 'success',
                    text: data.mensaje,
                    confirmButtonText: 'Aceptar'
                });

                $("#txt_nombre").val('');
                $("#txt_rut").val('');
                $("#dt_nacimiento").val('');
                $("#txt_email").val('');
                $("#txt_fono").val('');
                $("#cmb_region").val('');                
                $("#cmb_comuna").val('');
                $("#txt_sector").val('');
                

            }
        }
    });

}

function llenaRegiones() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "model/cmb_regiones.php",
    }).done(function (data) {
        $("#cmb_region").html('');

        // console.log('---'+data);

        regiones = "<option value=\"\">Seleccione una Region</option>";

        for (var i = 0; i < data.length; i++) {
            // console.log(data[i].CODIGO);
            regiones += "<option value=\"" + data[i].CODIGO + "\">" + data[i].NOMBRE + "</option>";
        }

        $("#cmb_region").append(regiones);
    });
}

function llenaComunas(region) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "model/cmb_comunas.php?region="+region,
    }).done(function (data) {
        $("#cmb_comuna").html('');

        regiones = "<option value=\"\">Seleccione una Comuna</option>";

        for (var i = 0; i < data.length; i++) {
            // console.log(data[i].CODIGO);
            regiones += "<option value=\"" + data[i].CODIGO + "\">" + data[i].NOMBRE + "</option>";
        }

        $("#cmb_comuna").append(regiones);
    });
}

$(document).ready(function () {
    llenaRegiones();
    llenaComunas(0);

    $("#cmb_region").change(function () {
        var region = $(this).val();
        llenaComunas(region);
    });

    $("#dt_nacimiento").blur(function (e) {
        var fecha = $(this).val();
        var regEx = /^\d{2}-\d{2}-\d{4}$/;
        if (!regEx.test(fecha)) {
            $(this).val('');
            // alert('');
            Swal.fire({
                icon: 'warning',
                title: 'El formato de fecha no es correcto. Por favor, use dd-mm-yyyy.',
                showConfirmButton: true
            });
            return;
        }
    });

    $("#txt_fono").keypress(function (e) {
        var keyCode = e.which;
        if (keyCode !== 8 && (keyCode < 48 || keyCode > 57)) {
            e.preventDefault();
        }
    });


    $("#txt_nombre").keypress(function (e) {
        var keyCode = e.which;
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) && keyCode != 32 && keyCode != 164) {
            e.preventDefault();
        }
    });

    $("#txt_sector").keypress(function (e) {
        var keyCode = e.which;
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 122) && (keyCode < 48 || keyCode > 57) && keyCode != 32) {
            e.preventDefault();
        }
    });


    $("#btn_enviar").click(function (e) {

        // enviarFormulario();
        // return;

        var txt_nombre = $("#txt_nombre").val();
        var txt_rut = $("#txt_rut").val();
        var dt_nacimiento = $("#dt_nacimiento").val();
        var txt_email = $("#txt_email").val();
        var txt_fono = $("#txt_fono").val();
        var cmb_region = $("#cmb_region").val();        
        var cmb_comuna = $("#cmb_comuna").val();
        var sector = $("#txt_sector").val();

        if (["#txt_nombre", "#txt_rut", "#dt_nacimiento", "#txt_email", "#txt_fono", "#cmb_region", "#cmb_comuna", "#txt_sector"].some(id => $(id).val() == "")) {
            Swal.fire({
                icon: 'warning',
                title: 'Llenar todos los datos',
                showConfirmButton: true
            });
            return;
        }

        var exp = /^[0-9]{1,8}-[0-9K]$/;
        if (!exp.test(txt_rut)) {
            Swal.fire({
                icon: 'warning',
                title: 'Rut no valido',
                showConfirmButton: true
            });
            return;
        }

        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(txt_email)) {
            Swal.fire({
                icon: 'warning',
                title: 'Correo no valido',
                showConfirmButton: true
            });
            return;
        }


        enviarFormulario();

       

    });

});