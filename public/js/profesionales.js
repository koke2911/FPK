

function llenaProfesiones() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../model/data_profesiones.php",
    }).done(function (data) {
        $("#cmb_profesion").html('');

        // console.log('---'+data);

        regiones = "<option value=\"\">Seleccione una profesion</option>";

        for (var i = 0; i < data.length; i++) {
            // console.log(data[i].CODIGO);
            regiones += "<option value=\"" + data[i].id + "\">" + data[i].nombre + "</option>";
        }

        $("#cmb_profesion").append(regiones);
    });
}

function llenaDatos(data){
    $("#txt_id").val(data.ID);
    $("#txt_rut").val(data.RUT);
    $("#txt_nombre").val(data.NOMBRE);
    $("#txt_apellido").val(data.APELLIDO);
    $("#cmb_profesion").val(data.PROFESION_ID);
    $("#cmb_estado").val(data.ESTADO_COD);
}


function guardarProfe(){
    var rut = $("#txt_rut").val();
    var nombre = $("#txt_nombre").val();
    var apellido = $("#txt_apellido").val();
    var profesion = $("#cmb_profesion").val();
    var estado = $("#cmb_estado").val();
    var id = $("#txt_id").val();

    $.ajax({
        url: "../model/update_profesional.php",
        type: "POST",
        dataType: 'json',
        data: {
            id: id,
            rut: rut,
            nombre: nombre,
            apellido: apellido,
            profesion: profesion,
            estado: estado
        },
        success: function (data) {
            if (data.codigo == 0) {
                Swal.fire({
                    title: 'Profesional actualizado',
                    text: '',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
                $("#grid_profesionales").dataTable().fnReloadAjax("../model/datagrid_profesionales.php");
                $("#txt_rut").val("");
                $("#txt_nombre").val("");
                $("#txt_apellido").val("");
                $("#cmb_profesion").val("");
                $("#cmb_estado").val("");
                $("#txt_id").val("");

            } else {
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    text: data.mensaje,
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        }
    });
    
}

$(document).ready(function () {

    llenaProfesiones();

    
    $("#txt_rut").on("blur", function(e){
        var rut = $("#txt_rut").val();

        if(!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rut )){
            Swal.fire({
                title: 'El rut debe ser sin puntos ej: 11111111-1',
                text: '',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        }
    });

    $('#btn_guardar').click(function() {
        var rut = $("#txt_rut").val();
        var nombre = $("#txt_nombre").val();
        var apellido = $("#txt_apellido").val();
        var profesion = $("#cmb_profesion").val();
        var estado = $("#cmb_estado").val();
        
        if (rut == "" || nombre == "" || apellido == "" || profesion == "" || estado == "") {
            Swal.fire({
                title: 'Llenar todos los datos',
                text: '',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

        guardarProfe();

       
    });



    var grid_profesionales = $('#grid_profesionales').DataTable({
        "responsive": true,
        "paging": true,
        "destroy": true,
        "ajax": "../model/datagrid_profesionales.php",
        "columns": [
            { "data": "ID", title: "#ID" },
            { "data": "RUT", title: "Rut" },
            { "data": "NOMBRE", title: "Nombre" },
            { "data": "APELLIDO", title: "Apellido" },
            { "data": "PROFESION", title: "Profesion" },
            { "data": "PROFESION_ID", title: "Profesion_id" ,visible: false},
            { "data": "ESTADO", title: "estado" },
            { "data": "ESTADO_COD", title: "estado_cod",visible: false}

        ],
        "select": {
            "style": "single"
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                title: 'Profesionales'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                title: 'Profesionales',
                orientation: 'portrait',
                pageSize: 'LETTER'
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                className: 'btn btn-info',
                title: "Informe de Arranques"
            },
        ],

        "language": {
            "decimal": "",
            "emptyTable": "No hay información",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
            "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
            "infoPostFix": "",
            "thousands": ",",
            "lengthMenu": "Mostrar _MENU_ Entradas",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "Sin resultados encontrados",
            "select": {
                "rows": "<br/>%d Tipos de atención Seleccionados"
            },
            "paginate": {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Sig.",
                "previous": "Ant."
            }
        }
    });

    $('#grid_profesionales tbody').on('dblclick', 'tr', function () {
        var data = grid_profesionales.row(this).data();
        llenaDatos(data);
    });

   
});