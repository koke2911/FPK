
let id = document.getElementById('id').value;


function LlenaDatos(id){
    $.ajax({
        url: "model/llenaDatosSolicitud.php",
        type: "POST",
        dataType: 'json',
        data: { id: id },
        success: function (data) {
            console.log(data);

                $("#txt_nombre").val(data.data[0].NOMBRE);
                $("#txt_edad").val(data.data[0].EDAD);
                $("#txt_rut").val(data.data[0].RUT);                
                $("#txt_fono").val(data.data[0].FONO);
                $("#txt_email").val(data.data[0].EMAIL);
                
           
        }
    });
}


function enviaValidacion(){
    var txt_nombre = $("#txt_nombre").val();
    var txt_edad = $("#txt_edad").val();
    var txt_rut = $("#txt_rut").val();
    var txt_direccion = $("#txt_direccion").val();
    var txt_nombre_adulto = $("#txt_nombre_adulto").val();
    var txt_fono = $("#txt_fono").val();
    var txt_email = $("#txt_email").val();

    var datos={
        id:id,
        txt_nombre:txt_nombre,
        txt_edad:txt_edad,
        txt_rut:txt_rut,
        txt_direccion:txt_direccion,
        txt_nombre_adulto:txt_nombre_adulto,
        txt_fono:txt_fono,
        txt_email:txt_email
    };

    Swal.fire({
        title: 'Un momento por favor...',
        html: 'Estamos validando la información',
        // allowOutsideClick: false,
        onBeforeOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        type: 'POST',
        url: 'model/envia_validacion.php',
        data: datos,
        dataType: 'json',
        success: function (data) {
            Swal.close();
            if (data.codigo == 2) {
                Swal.fire({
                    title: 'Atención',
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

                $("#txt_nombre").prop('disabled', true);
                $("#txt_edad").prop('disabled', true);
                $("#txt_rut").prop('disabled', true);
                $("#txt_direccion").prop('disabled', true);
                $("#txt_nombre_adulto").prop('disabled', true);
                $("#txt_fono").prop('disabled', true);
                $("#txt_email").prop('disabled', true);
            }
        }
    });

}



$(document).ready(function () {

    LlenaDatos(id);

    // Add input validation for txt_direccion and txt_nombre_adulto
    $("#txt_direccion, #txt_nombre_adulto").on("input", function () {
        this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, '');
    });


    $("#btn_enviar").click(function () {
        let txt_direccion = $("#txt_direccion").val();
        let txt_nombre_adulto = $("#txt_nombre_adulto").val();
        let txt_fono = $("#txt_fono").val();

        if (txt_direccion.trim() === "" || txt_nombre_adulto.trim() === "" || txt_fono.trim() === "") {
            Swal.fire({
                title: 'Campos vacíos',
                text: 'Por favor, asegúrese de que los campos Dirección, Nombre Adulto y Fono no estén vacíos.',
                icon: 'warning',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        enviaValidacion();

    });

});