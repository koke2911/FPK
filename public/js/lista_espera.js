var id_solicitud;

function verTraza(id){
    
}


function busca_fecha() {
    $.ajax({
        url: "../model/fecha_lista.php",
        type: "GET",
        // dataType: 'json',
        success: function (data) {
            $('#fecha_lista').val(data);
        }
    });
}


$(document).ready(function () {
    busca_fecha();


    var grid_solicitudes = $('#grid_solicitudes').DataTable({
        "responsive": true,
        "paging": true,
        "destroy": true,
        "ajax": "../model/datagrid_lista_espera.php",
        "columns": [
            { "data": "ID", visible: false },
            { "data": "NOMBRE" },
            { "data": "RUT" },
            { "data": "EDAD" },
            { "data": "NOMBRE_RESPONSABLE" },
            { "data": "EMAIL" },
            { "data": "FONO" },
            { "data": "COMUNA" },
            { "data": "DIRECCION" },
            { "data": "FECHA_SOLICITUD" },
            {
                "data": "ESTADO",
                render: function(data, type, row, meta) {
                    let color = '';
                    switch (data) {
                        case 'Correo enviado':
                            color = 'yellow';
                            break;
                        case 'Seguimiento Whatsapp':
                            color = 'orange';
                            break;
                        case 'Terapeuta designada':
                            color = 'green';
                            break;
                        case 'Proceso completado':
                            color = '#b969b9';
                            break;
                        case 'No contesto correo':
                            color = 'red';
                            break;
                        case 'No siguio el proceso':
                            color = '#e63d3d';
                            break;
                        default:
                            color = 'withe';
                    }
                    return `<span style="background-color: ${color}">${data}</span>`;
                }
            },
            { "data": "ID",
                render: function (data, type, row, meta) {                   
                        return '<button type="button" class="btn btn-info" onclick="verTraza(' + data + ')" title="Ver traza"><i class="fa fa-eye" aria-hidden="true"></i></button>';
                }
             },

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
                title: 'solicitudes en lista de espera'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                title: 'solicitudes en lista de espera',
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

    $('#grid_solicitudes tbody').on('dblclick', 'tr', function () {
        var data = grid_solicitudes.row(this).data();
        id_solicitud=data.ID;
        $('#modal_estado').modal('show');

    });

    $('#btn_guardar_estado').click(function () {

        var id = $("#id_estado").val();
        var estado = $("#cmb_estado").val();
        var observacion = $("#observacion").val();
        $.ajax({
            url: "../model/update_estado_le.php",
            type: "POST",
            dataType: 'json',
            data: {
                id: id_solicitud,
                estado: estado,
                observacion: observacion
            },
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
                        title: 'Solicitud Modificada correctamente',
                        icon: 'success',
                        text: data.mensaje,
                        confirmButtonText: 'Aceptar'
                    });
                    $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_lista_espera.php");
                }
            }
        });
        $('#modal_estado').modal('hide');
    });

    $('#btn_actualizar_fecha').click(function () {

        var fecha = $("#fecha_lista").val();
        console.log(fecha);

        $.ajax({
            url: "../model/update_fecha_solicitud.php",
            type: "POST",
            dataType: 'json',
            data: {
                fecha: fecha
            },
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
                        title: 'Fecha de solicitud modificada correctamente',
                        icon: 'success',
                        text: data.mensaje,
                        confirmButtonText: 'Aceptar'
                    });
                    // $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_lista_espera.php");
                }
            }
        });
        $('#modal_fecha').modal('hide');
    });

});