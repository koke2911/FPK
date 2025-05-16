


function enviarFormulario(){

    var txt_nombre = $("#txt_nombre").val();
    var txt_rut = $("#txt_rut").val();
    var txt_edad = $("#txt_edad").val();
    var txt_email = $("#txt_email").val();
    var txt_fono = $("#txt_fono").val();
    var cmb_region = $("#cmb_region").val();
    var cmb_ciudad = $("#cmb_ciudad").val();
    var cmb_comuna = $("#txt_comuna").val();

    var data = {
        txt_nombre:txt_nombre,
        txt_rut:txt_rut,
        txt_edad:txt_edad,
        txt_email:txt_email,
        txt_fono:txt_fono,
        cmb_region:cmb_region,
        cmb_ciudad:cmb_ciudad,
        cmb_comuna:cmb_comuna
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
                $("#txt_edad").val('');
                $("#txt_email").val('');
                $("#txt_fono").val('');
                $("#cmb_region").val('');
                $("#cmb_ciudad").val('');
                $("#txt_comuna").val('');
                

            }
        }
    });

}

$(document).ready(function () {

    var regiones = [
        { codigo: '01', nombre: 'Tarapacá' },
        { codigo: '02', nombre: 'Antofagasta' },
        { codigo: '03', nombre: 'Atacama' },
        { codigo: '04', nombre: 'Coquimbo' },
        { codigo: '05', nombre: 'Valparaíso' },
        { codigo: '06', nombre: 'O’Higgins' },
        { codigo: '07', nombre: 'Maule' },
        { codigo: '08', nombre: 'Biobío' },
        { codigo: '09', nombre: 'Araucanía' },
        { codigo: '10', nombre: 'Los Lagos' },
        { codigo: '11', nombre: 'Aysén' },
        { codigo: '12', nombre: 'Magallanes' },
        { codigo: '13', nombre: 'Metropolitana' },
        { codigo: '14', nombre: 'Los Ríos' },
        { codigo: '15', nombre: 'Arica y Parinacota' },
        { codigo: '16', nombre: 'Ñuble' }
    ];

    $("#cmb_region").append('<option value="">Seleccionar Región</option>');
    $.each(regiones, function (i, reg) {
        $("#cmb_region").append('<option value="' + reg.codigo + '">' + reg.nombre + '</option>');
    });

    var ciudades = [
        { codigo: '0101', nombre: 'Iquique' },
        { codigo: '0102', nombre: 'Alto Hospicio' },
        { codigo: '0201', nombre: 'Antofagasta' },
        { codigo: '0202', nombre: 'Mejillones' },
        { codigo: '0203', nombre: 'Sierra Gorda' },
        { codigo: '0204', nombre: 'Taltal' },
        { codigo: '0301', nombre: 'Copiapó' },
        { codigo: '0302', nombre: 'Chañaral' },
        { codigo: '0303', nombre: 'Diego de Almagro' },
        { codigo: '0304', nombre: 'Caldera' },
        { codigo: '0305', nombre: 'Tierra Amarilla' },
        { codigo: '0306', nombre: 'Vallenar' },
        { codigo: '0401', nombre: 'La Serena' },
        { codigo: '0402', nombre: 'Coquimbo' },
        { codigo: '0403', nombre: 'Andacollo' },
        { codigo: '0404', nombre: 'La Higuera' },
        { codigo: '0405', nombre: 'Paihuano' },
        { codigo: '0406', nombre: 'Vicuña' },
        { codigo: '0501', nombre: 'Valparaíso' },
        { codigo: '0502', nombre: 'Viña del Mar' },
        { codigo: '0503', nombre: 'Concón' },
        { codigo: '0504', nombre: 'Quilpué' },
        { codigo: '0505', nombre: 'Quintero' },
        { codigo: '0506', nombre: 'Puchuncaví' },
        { codigo: '0507', nombre: 'Casablanca' },
        { codigo: '0508', nombre: 'Juan Fernández' },
        { codigo: '0601', nombre: 'Rancagua' },
        { codigo: '0602', nombre: 'San Fernando' },
        { codigo: '0603', nombre: 'Curicó' },
        { codigo: '0604', nombre: 'Talca' },
        { codigo: '0701', nombre: 'Talca' },
        { codigo: '0702', nombre: 'Curicó' },
        { codigo: '0703', nombre: 'Linares' },
        { codigo: '0704', nombre: 'Cauquenes' },
        { codigo: '0801', nombre: 'Chillán' },
        { codigo: '0802', nombre: 'Concepción' },
        { codigo: '0803', nombre: 'Coronel' },
        { codigo: '0804', nombre: 'Los Ángeles' },
        { codigo: '0901', nombre: 'Temuco' },
        { codigo: '0902', nombre: 'Angol' },
        { codigo: '0903', nombre: 'Villarrica' },
        { codigo: '0904', nombre: 'Padre Las Casas' },
        { codigo: '1001', nombre: 'Puerto Montt' },
        { codigo: '1002', nombre: 'Osorno' },
        { codigo: '1003', nombre: 'Puerto Varas' },
        { codigo: '1101', nombre: 'Coyhaique' },
        { codigo: '1102', nombre: 'Chile Chico' },
        { codigo: '1103', nombre: 'Coihaique Alto' },
        { codigo: '1201', nombre: 'Punta Arenas' },
        { codigo: '1202', nombre: 'Porvenir' },
        { codigo: '1203', nombre: 'Natales' },
        { codigo: '1301', nombre: 'Santiago' },
        { codigo: '1302', nombre: 'Puente Alto' },
        { codigo: '1303', nombre: 'Maipú' },
        { codigo: '1304', nombre: 'La Florida' },
        { codigo: '1305', nombre: 'San Bernardo' },
        { codigo: '1401', nombre: 'Valdivia' },
        { codigo: '1402', nombre: 'Los Lagos' },
        { codigo: '1501', nombre: 'Arica' },
        { codigo: '1502', nombre: 'Parinacota' },
        { codigo: '1601', nombre: 'Chillán' },
        { codigo: '1602', nombre: 'Bulnes' },
    ];

    $("#cmb_ciudad").append('<option value="">Seleccionar Ciudad</option>');

    $.each(ciudades, function (i, ciu) {
        $("#cmb_ciudad").append('<option value="' + ciu.codigo + '">' + ciu.nombre + '</option>');
    });

    $("#btn_enviar").click(function (e) {

        // enviarFormulario();
        // return;

        var txt_nombre = $("#txt_nombre").val();
        var txt_rut = $("#txt_rut").val();
        var txt_edad = $("#txt_edad").val();
        var txt_email = $("#txt_email").val();
        var txt_fono = $("#txt_fono").val();
        var cmb_region = $("#cmb_region").val();
        var cmb_ciudad = $("#cmb_ciudad").val();
        var cmb_comuna = $("#cmb_cmuna").val();

        if (["#txt_nombre", "#txt_rut", "#txt_edad", "#txt_email", "#txt_fono", "#cmb_region", "#cmb_ciudad", "#cmb_cmuna"].some(id => $(id).val() == "")) {
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