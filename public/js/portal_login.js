

function login() {
    let usuario = $("#txt_usuario").val();
    let pass = $("#txt_contraseña").val();

    if (usuario == "" || pass == "") {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ambos campos son obligatorios'
        });
        e.preventDefault();
        return;
    }

    $.post("../model/portal_login.php", { usuario: usuario, pass: pass }, function (data) {
        if (data == 1) {
            window.location.href = "principal.php";
        } else {

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data
            });
        }
    });
}

$(document).ready(function () {


    $("#txt_usuario").keyup(function () {
        //    / this.value = this.value.replace(/\./g, '').replace(/\s/g, '').replace(/-/g, '');
    });

    $("#txt_contraseña").keyup(function () {
        // this.value = this.value.replace(/[^a-zA-Z0-9]/g, '');
    });


    $("#btn_ingresar").click(function () {
        login();
    });

    $('#txt_contraseña').on('keypress', function (event) {
        if (event.which === 13) {
            login();
        }
    });




});