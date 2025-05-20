
$(document).ready(function () {

    // $('#principal').attr('src', '../views/portal.php');


    $('#ocultarBarraLateral').click(function () {
        $('nav').toggleClass('show');
    });

    $('#cerrarSesion').click(function () {

        location.href = "../model/logout.php";
    });




    $('#menu_solicitudes').click(function () {
        $('#principal').attr('src', '../views/solicitudes.php?estado=0');
    })

    $('#menu_rechazadas').click(function () {
        $('#principal').attr('src', '../views/solicitudes.php?estado=1');
    })

    $('#menu_listaE').click(function () {
        $('#principal').attr('src', '../views/lista_espera.php');
    })

    $('#menu_finish').click(function () {
        $('#principal').attr('src', '../views/finalizadas.php');
    })


    $('#menu_atencion').click(function () {
        $('#principal').attr('src', '../views/atenciones.php');
    })

    $('#menu_servicios').click(function () {
        $('#principal').attr('src', '../views/servicios.php');
    })
    

    

    





});