
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
                        LlenaSolicitudes(estado);
                        // $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_solicitudes.php?estado=" + estado);
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
                            LlenaSolicitudes(estado);
                            // $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_solicitudes.php?estado="+estado);
                        }
                    }
                });
            }
        });
}

function verTraza(id){
    window.location.href = "../views/ver_traza.php?id="+id;
}

function LlenaSolicitudes(estado){
    $.ajax({
        url: "../model/datagrid_solicitudes.php?estado=" + estado,
        method: "GET",
        dataType: "json",
        success: function (response) {
            const container = $('#cards_container');
            container.empty();

            response.data.forEach(row => {
                const btnCorreo = (estado != 0)
                    ? `<button class="btn btn-primary" disabled><i class="fa fa-envelope"></i></button>`
                    : `<button class="btn ${row.CORREO == 1 ? 'btn-success' : 'btn-primary'}" onclick="enviarMail(${row.ID})"><i class="fa fa-envelope"></i></button>`;

                const btnAccion = (estado != 0)
                    ? `<button class="btn btn-success" onclick="rechazarSolicitud(${row.ID})" title="Reabrir solicitud"><i class="fa fa-reply"></i></button>`
                    : `<button class="btn btn-danger" onclick="rechazarSolicitud(${row.ID})" title="Rechazar solicitud"><i class="fa fa-times"></i></button>`;
                
                let btnTraza = `<button class="btn btn-primary" onclick="verTraza(${row.ID})" title="Ver traza"><i class="fa fa-eye"></i></button>`;

                const card = `
                <div class="col-md-6 col-xl-4" style="margin-bottom: 20px;">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">#${row.ID} <strong>${row.NOMBRE}</strong> (${row.EDAD})</h5>
                            <p class="card-text">
                                
                                <strong>RUT:</strong> ${row.RUT}<br>
                                <strong>Email:</strong> ${row.EMAIL}<br>
                                <strong>Fono:</strong> ${row.FONO}<br>
                                <strong>Región-Comuna:</strong> ${row.REGION}<br>
                                <strong>Sector:</strong> ${row.SECTOR}<br>
                                <strong>Fecha Solicitud:</strong> ${row.FECHA_SOLICITUD}
                            </p>
                            <div class="d-flex justify-content-between">
                                ${btnCorreo}
                                ${btnAccion}
                                ${btnTraza}
                            </div>
                        </div>
                    </div>
                </div>
            `;

                container.append(card);
            });
        },
        error: function () {
            $('#cards_container').html('<div class="alert alert-danger">Error al cargar las solicitudes</div>');
        }
    });
}
$(document).ready(function () {

    LlenaSolicitudes(estado);

    $('#buscadorTarjetas').on('keyup', function () {
        const valorBusqueda = $(this).val().toLowerCase();

        $('#cards_container .card').each(function () {
            const textoCard = $(this).text().toLowerCase();

            if (textoCard.indexOf(valorBusqueda) > -1) {
                $(this).parent().show(); // .parent() porque .card está dentro de un .col
            } else {
                $(this).parent().hide();
            }
        });
    });


    // var grid_solicitudes = $('#grid_solicitudes').DataTable({
    //     "responsive": true,
    //     "paging": true,
    //     "destroy": true,
    //     "ajax": "../model/datagrid_solicitudes.php?estado=" + estado,
    //     "columns": [
    //         { "data": "ID" ,"visible":false},
    //         { "data": "NOMBRE" },
    //         { "data": "RUT" },
    //         { "data": "EDAD" },
    //         { "data": "EMAIL" },
    //         { "data": "FONO" },
    //         { "data": "REGION" },
    //         // { "data": "COMUNA" },
    //         { "data": "SECTOR" },
    //         { "data": "FECHA_SOLICITUD" },
    //         {
    //             "data": "ID",
    //             render: function (data, type, row, meta) {
    //                 if(estado != 0){
    //                     return '<button type="button" class="btn btn-primary" onclick="enviarMail(' + data + ')" disabled><i class="fa fa-envelope" aria-hidden="true"></i></button>';
    //                 }else{
    //                     if (row.CORREO == 1) {
    //                         return '<button type="button" class="btn btn-success" onclick="enviarMail(' + data + ')"><i class="fa fa-envelope" aria-hidden="true"></i></button>';
    //                     } else {
    //                         return '<button type="button" class="btn btn-primary" onclick="enviarMail(' + data + ')"><i class="fa fa-envelope" aria-hidden="true"></i></button>';
    //                     }

    //                    return '<button type="button" class="btn btn-primary" onclick="enviarMail(' + data + ')"><i class="fa fa-envelope" aria-hidden="true"></i></button>';
    //                 }
    //             }
    //         },
    //         {
    //             "data": "ID",
    //             render: function (data, type, row, meta) {
    //                 if (estado != 0) {
    //                     return '<button type="button" class="btn btn-success" onclick="rechazarSolicitud(' + data + ')" title="Reabrir solicitud"><i class="fa fa-reply" aria-hidden="true"></i></button>';
    //                 } else {
    //                     return '<button type="button" class="btn btn-danger" onclick="rechazarSolicitud(' + data + ')" title="Rechazar solicitud"><i class="fa fa-times" aria-hidden="true"></i></button>';
    //                 }
    //             }
    //         },
    //         {
    //             "data": "CORREO",visible:false
    //          },

    //     ],
    //     "select": {
    //         "style": "single"
    //     },
    //     dom: 'Bfrtip',
    //     buttons: [
    //         {
    //             extend: 'excelHtml5',
    //             text: '<i class="fas fa-file-excel"></i> Excel',
    //             titleAttr: 'Exportar a Excel',
    //             className: 'btn btn-success',
    //             title: glosa_estado
    //         },
    //         {
    //             extend: 'pdfHtml5',
    //             text: '<i class="fas fa-file-pdf"></i> PDF',
    //             titleAttr: 'Exportar a PDF',
    //             className: 'btn btn-danger',
    //             title: glosa_estado,
    //             orientation: 'portrait',
    //             pageSize: 'LETTER'
    //         },
    //         {
    //             extend: 'print',
    //             text: '<i class="fa fa-print"></i> Imprimir',
    //             titleAttr: 'Imprimir',
    //             className: 'btn btn-info',
    //             title: "Informe de Arranques"
    //         },
    //     ],

    //     "language": {
    //         "decimal": "",
    //         "emptyTable": "No hay información",
    //         "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
    //         "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
    //         "infoFiltered": "(Filtrado de _MAX_ total entradas)",
    //         "infoPostFix": "",
    //         "thousands": ",",
    //         "lengthMenu": "Mostrar _MENU_ Entradas",
    //         "loadingRecords": "Cargando...",
    //         "processing": "Procesando...",
    //         "search": "Buscar:",
    //         "zeroRecords": "Sin resultados encontrados",
    //         "select": {
    //             "rows": "<br/>%d Tipos de atención Seleccionados"
    //         },
    //         "paginate": {
    //             "first": "Primero",
    //             "last": "Ultimo",
    //             "next": "Sig.",
    //             "previous": "Ant."
    //         }
    //     }
    // });
   
});