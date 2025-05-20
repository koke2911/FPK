var id_solicitud;

function verTraza(id) {
    window.location.href = "../views/ver_traza.php?id=" + id;
}

function verFicha(data){
    const container = $('#cards_container');
    container.empty();
    const btnAccion = `<button class="btn btn-success" title="Cambiar estado" disabled><i class="fa fa-book"></i></button>`;
    const btnAsignaServicio = `<button class="btn btn-warning"  title="Asignaciones" disabled><i class="fa fa-hospital"></i></button>`;
    let btnTraza = `<button class="btn btn-primary"  title="Ver traza" disabled><i class="fa fa-eye"></i></button>`;

    const card = `
                <div class="col-md-12 col-xl-12" style="margin-bottom: 20px;">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">#${data.ID} <strong>${data.NOMBRE}</strong> <br>${data.EDAD}</h5>
                            <p class="card-text">
                                <strong>RUT:</strong> ${data.RUT}<br>
                                <strong>Responsable:</strong> ${data.NOMBRE_RESPONSABLE}<br>
                                <strong>Email:</strong> ${data.EMAIL}<br>
                                <strong>Fono:</strong> ${data.FONO}<br>
                                <strong>Región-Comuna:</strong> ${data.COMUNA}<br>
                                <strong>Sector:</strong> ${data.DIRECCION}<br>
                                <strong>Fecha Solicitud:</strong> ${data.FECHA_SOLICITUD}<br>
                                <strong>Servicio:</strong> ${data.SERVICIO}<br>
                                <strong>Sesiones:</strong> ${data.SESIONES}<br>
                                <strong>Terapeuta:</strong> ${data.NOMBRE_PROFESIONAL}<br>                                
                                <i class="fab fa-whatsapp"></i><strong> Contacto Whatsapp:</strong> <input type="checkbox" onclick="registraCheck(${data.ID}, this.checked,'W')" ${data.WHATSAPP == 'true' ? 'checked' : ''} disabled><br>
                                <i class="fas fa-video"></i><strong> Reunión OnLine:</strong> <input type="checkbox" onclick="registraCheck(${data.ID}, this.checked,'R')" ${data.REUNION == 'true' ? 'checked' : ''} disabled><br>
                                <i class="fas fa-money-bill-wave"></i><strong> Pago mensualidad:</strong> <input type="checkbox" onclick="registraCheck(${data.ID}, this.checked,'M')" ${data.MENSUALIDAD == 'true' ? 'checked' : ''} disabled><br>
                            </p>
                            <div class="d-flex justify-content-between">
                                ${btnAccion}
                                ${btnAsignaServicio}
                                ${btnTraza}
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            `;

    container.append(card);
    $("#modal_ficha").modal('show');
    
}

$(document).ready(function () {



    var grid_solicitudes = $('#grid_solicitudes').DataTable({
        "responsive": true,
        "paging": true,
        "destroy": true,
        "ajax": "../model/datagrid_finalizadas.php",
        "columns": [
            { "data": "ID"},            
            { "data": "NOMBRE" },
            { "data": "RUT" },
            { "data": "EDAD" },
            { "data": "NOMBRE_RESPONSABLE",visible:false },
            { "data": "EMAIL",visible:false },
            { "data": "FONO" },
            { "data": "COMUNA" },
            { "data": "DIRECCION",visible:false },
            { "data": "FECHA_SOLICITUD" },
            {
                "data": "ESTADO",
                render: function (data, type, row, meta) {
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
            {
                "data": "ID",
                render: function (data, type, row, meta) {
                    return '<button type="button" class="btn btn-primary ver_ficha"  title="Ver ficha"><i class="fa fa-file-text" aria-hidden="true"></i></button>';
                }
            },
            {
                "data": "ID",
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
        id_solicitud = data.ID;
        $('#modal_estado').modal('show');
    });


    $('#grid_solicitudes').on('click', '.ver_ficha', function () {
        const table = $('#grid_solicitudes').DataTable();

        // Obtener la fila a la que pertenece el botón clickeado
        const rowData = table.row($(this).closest('tr')).data();

        // console.log("Fila completa:", rowData);

        verFicha(rowData);
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
                    $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_finalizadas.php");
                }
            }
        });
        $('#modal_estado').modal('hide');
    });

});