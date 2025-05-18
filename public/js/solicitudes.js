
let estado = document.getElementById('estado').value;
let glosa_estado;
let glosa_text;
let casilla;;

if(estado==0){
    glosa_estado='Solicitudes Abiertas';
    glosa_text="Rechazar";
    casilla="Rechazadas";
    
}else{
    glosa_estado = 'Solicitudes Rechazadas';
    glosa_text=" Reabrir";
    casilla="Solicitudes";
}

function enviarMail(id){
    swal.fire({
        title: "Desea enviar mail a este usuario?",
        text: "Si confirma, se enviará un correo con un link para el llenado del formulario, una vez que el cliente llene el formulario pasará automáticamente a lista de espera.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Enviar',
        cancelButtonText: 'Cancelar',
    })
    .then((willDelete) => {
        if (willDelete.isConfirmed) {

            Swal.fire({
                title: 'Enviando correo...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url: "../model/enviar_mail.php",
                type: "POST",
                dataType: 'json',
                data: {id: id},
                success: function (data) {
                    Swal.close();
                    if(data.codigo == 2) {
                        Swal.fire({
                            title: 'Ha ocurrido un error',
                            text: data.mensaje,
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    } else {
                        Swal.fire({
                            title: 'Email enviado',
                            icon: 'success',
                            text: data.mensaje,
                            confirmButtonText: 'Aceptar'
                        });
                        $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_solicitudes.php?estado=" + estado);
                    }
                }
            });
        }
    });
}

function rechazarSolicitud(id){
    swal.fire({
        title: "Desea " + glosa_text +" esta solicitud de contacto?",
        text: "Si confirma, esta solicitud quedará en la casilla de " + casilla + ".",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar',
        cancelButtonText: 'Cancelar',
    })
        .then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url: "../model/rechazar_solicitud.php",
                    type: "POST",
                    dataType: 'json',
                    data: { id: id,estado:estado },
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
                                title: 'Solicitud de contacto rechazada',
                                icon: 'success',
                                text: data.mensaje,
                                confirmButtonText: 'Aceptar'
                            });
                            $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_solicitudes.php?estado="+estado);
                        }
                    }
                });
            }
        });
}

$(document).ready(function () {



    var grid_solicitudes = $('#grid_solicitudes').DataTable({
        "responsive": true,
        "paging": true,
        "destroy": true,
        "ajax": "../model/datagrid_solicitudes.php?estado=" + estado,
        "columns": [
            { "data": "ID" ,"visible":false},
            { "data": "NOMBRE" },
            { "data": "RUT" },
            { "data": "EDAD" },
            { "data": "EMAIL" },
            { "data": "FONO" },
            { "data": "REGION" },
            // { "data": "COMUNA" },
            { "data": "SECTOR" },
            { "data": "FECHA_SOLICITUD" },
            {
                "data": "ID",
                render: function (data, type, row, meta) {
                    if(estado != 0){
                        return '<button type="button" class="btn btn-primary" onclick="enviarMail(' + data + ')" disabled><i class="fa fa-envelope" aria-hidden="true"></i></button>';
                    }else{
                        if (row.CORREO == 1) {
                            return '<button type="button" class="btn btn-success" onclick="enviarMail(' + data + ')"><i class="fa fa-envelope" aria-hidden="true"></i></button>';
                        } else {
                            return '<button type="button" class="btn btn-primary" onclick="enviarMail(' + data + ')"><i class="fa fa-envelope" aria-hidden="true"></i></button>';
                        }

                       return '<button type="button" class="btn btn-primary" onclick="enviarMail(' + data + ')"><i class="fa fa-envelope" aria-hidden="true"></i></button>';
                    }
                }
            },
            {
                "data": "ID",
                render: function (data, type, row, meta) {
                    if (estado != 0) {
                        return '<button type="button" class="btn btn-success" onclick="rechazarSolicitud(' + data + ')" title="Reabrir solicitud"><i class="fa fa-reply" aria-hidden="true"></i></button>';
                    } else {
                        return '<button type="button" class="btn btn-danger" onclick="rechazarSolicitud(' + data + ')" title="Rechazar solicitud"><i class="fa fa-times" aria-hidden="true"></i></button>';
                    }
                }
            },
            {
                "data": "CORREO",visible:false
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
                title: glosa_estado
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                titleAttr: 'Exportar a PDF',
                className: 'btn btn-danger',
                title: glosa_estado,
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
   
});