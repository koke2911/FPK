var id_solicitud;

function verTraza(id) {
    window.location.href = "../views/ver_traza.php?id=" + id;
}
var estado=0;
function cargaModal(ID){
        id_solicitud = ID;
        $('#modal_estado').modal('show');
}

function registraCheck(id, checked, tipo) { // W R M

    $.ajax({
        url: "../model/registra_check.php",
        type: "POST",
        dataType: 'json',
        data: {
            id: id,
            checked: checked,
            tipo: tipo
        },
        success: function (data) {
            if (data.codigo == 2) {
                Swal.fire({
                    title: 'Ha ocurrido un error',
                    text: data.mensaje,
                    icon: 'error',
                    confirmButtonText: 'Aceptar',
                    timer: 1000,
                    onClose: () => {
                        Swal.close();
                    }
                });
            } else {
                Swal.fire({
                    title: 'accion registrada',
                    icon: 'success',
                    text: data.mensaje,
                    confirmButtonText: 'Aceptar',
                    timer: 1000,
                    onClose: () => {
                        Swal.close();
                    }                
                });
                LlenaSolicitudes();
                // $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_solicitudes.php?estado=" + estado);
            }
        }
    });

}

function llenaServicios() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../model/data_servicios.php",
    }).done(function (data) {
        $("#cmb_servicios").html('');

        // console.log('---'+data);

        regiones = "";

        for (var i = 0; i < data.length; i++) {
            // console.log(data[i].CODIGO);
            regiones += "<option value=\"" + data[i].id + "\">" + data[i].nombre + "</option>";
        }

        $("#cmb_servicios").append(regiones);
    });
}

function llenaProfesionales() {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "../model/data_profesionales.php",
    }).done(function (data) {
        $("#cmb_terapeuta").html('');

        // console.log('---'+data);

        regiones = "";

        for (var i = 0; i < data.length; i++) {
            // console.log(data[i].CODIGO);
            regiones += "<option value=\"" + data[i].id + "\">" + data[i].nombre + "</option>";
        }

        $("#cmb_terapeuta").append(regiones);
    });
}

function asignaOpciones(id, servicio_id, profesional_id, totales, actuales) {
    // console.log(servicio_id);
    // $('#modal_asignar').modal('show');
    id_solicitud = id;
    $('#cmb_servicios').val(servicio_id);
    $('#cmb_terapeuta').val(profesional_id);
    $('#sesiones_totales').val(totales);
    $('#sesiones_actuales').val(actuales);
    $('#modal_asignar').modal('show');
}

function LlenaSolicitudes() {
    $.ajax({
        url: "../model/datagrid_atencion.php",
        method: "GET",
        dataType: "json",
        success: function (response) {
            const container = $('#cards_container');
            container.empty();

            response.data.forEach(row => {
               

                const btnAccion = `<button class="btn btn-success" onclick="cargaModal(${row.ID})" title="Cambiar estado"><i class="fa fa-book"></i></button>`;
                const btnAsignaServicio = `<button class="btn btn-warning" onclick="asignaOpciones(${row.ID},${row.SERVICIO_ID},${row.PROFESIONAL_ID},${row.SESIONES_TOTALES},${row.SESIONES_ACTUALES})" title="Asignaciones"><i class="fa fa-hospital"></i></button>`;
                let btnTraza = `<button class="btn btn-primary" onclick="verTraza(${row.ID})" title="Ver traza"><i class="fa fa-eye"></i></button>`;
                    

                const card = `
                <div class="col-md-6 col-xl-4" style="margin-bottom: 20px;">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">#${row.ID} <strong>${row.NOMBRE}</strong> (${row.EDAD})</h5>
                            <p class="card-text">
                                <strong>RUT:</strong> ${row.RUT}<br>
                                <strong>Responsable:</strong> ${row.NOMBRE_RESPONSABLE}<br>
                                <strong>Email:</strong> ${row.EMAIL}<br>
                                <strong>Fono:</strong> ${row.FONO}<br>
                                <strong>Región-Comuna:</strong> ${row.COMUNA}<br>
                                <strong>Sector:</strong> ${row.DIRECCION}<br>
                                <strong>Fecha Solicitud:</strong> ${row.FECHA_SOLICITUD}<br>
                                <strong>Servicio:</strong> ${row.SERVICIO}<br>
                                <strong>Sesiones:</strong> ${row.SESIONES}<br>
                                <strong>Terapeuta:</strong> ${row.NOMBRE_PROFESIONAL}<br>  
                                <i class="fab fa-whatsapp"></i><strong> Contacto Whatsapp:</strong> <input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'W')" ${row.WHATSAPP == 'true' ? 'checked' : ''} ><br>
                                <i class="fas fa-video"></i><strong> Reunión OnLine:</strong> <input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'R')" ${row.REUNION == 'true' ? 'checked' : ''} ><br>
                                <i class="fas fa-money-bill-wave"></i><strong> Pago mensualidad:</strong> <input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'M')" ${row.MENSUALIDAD == 'true' ? 'checked' : ''} ><br>
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
            });
        },
        error: function () {
            $('#cards_container').html('<div class="alert alert-danger">Error al cargar las solicitudes</div>');
        }
    });
}

$(document).ready(function () {

    LlenaSolicitudes(estado);
    llenaServicios();
    llenaProfesionales();

    // var grid_solicitudes = $('#grid_solicitudes').DataTable({
    //     "responsive": true,
    //     "paging": true,
    //     "destroy": true,
    //     "ajax": "../model/datagrid_atencion.php",
    //     "columns": [
    //         { "data": "ID", visible: false },
    //         { "data": "NOMBRE" },
    //         { "data": "RUT" },
    //         { "data": "EDAD" },
    //         { "data": "NOMBRE_RESPONSABLE" },
    //         { "data": "EMAIL" },
    //         { "data": "FONO" },
    //         { "data": "COMUNA" },
    //         { "data": "DIRECCION" },
    //         { "data": "FECHA_SOLICITUD" },
    //         {
    //             "data": "ESTADO",
    //             render: function (data, type, row, meta) {
    //                 let color = '';
    //                 switch (data) {
    //                     case 'Correo enviado':
    //                         color = 'yellow';
    //                         break;
    //                     case 'Seguimiento Whatsapp':
    //                         color = 'orange';
    //                         break;
    //                     case 'Terapeuta designada':
    //                         color = 'green';
    //                         break;
    //                     case 'Proceso completado':
    //                         color = '#b969b9';
    //                         break;
    //                     case 'No contesto correo':
    //                         color = 'red';
    //                         break;
    //                     case 'No siguio el proceso':
    //                         color = '#e63d3d';
    //                         break;
    //                     case 'En atención':
    //                         color = '#80dd8a';
    //                         break;
    //                     default:
    //                         color = 'withe';
    //                 }
    //                 return `<span style="background-color: ${color}">${data}</span>`;
    //             }
    //         },
    //         {
    //             "data": "ID",
    //             render: function (data, type, row, meta) {
    //                 return '<button type="button" class="btn btn-info" onclick="verTraza(' + data + ')" title="Ver traza"><i class="fa fa-eye" aria-hidden="true"></i></button>';
    //             }
    //         },

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
    //             title: 'solicitudes en lista de espera'
    //         },
    //         {
    //             extend: 'pdfHtml5',
    //             text: '<i class="fas fa-file-pdf"></i> PDF',
    //             titleAttr: 'Exportar a PDF',
    //             className: 'btn btn-danger',
    //             title: 'solicitudes en lista de espera',
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

    // $('#grid_solicitudes tbody').on('dblclick', 'tr', function () {
    //     var data = grid_solicitudes.row(this).data();
    //     id_solicitud = data.ID;
    //     $('#modal_estado').modal('show');
    // });

    $('#btn_guardar_estado').click(function () {

        var id = $("#id_estado").val();
        var estado = $("#cmb_estado").val();
        var observacion = $("#observacion").val();

        if ($("#cmb_estado").val() == "") {
            Swal.fire({
                icon: 'warning',
                title: 'Debe seleccionar un estado',
                showConfirmButton: true
            });
            return false;
        }
        
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
                    LlenaSolicitudes();
                    // $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_atencion.php");
                }
            }
        });
        $('#modal_estado').modal('hide');
    });

    $('#btn_guarda_asingacion').click(function () {
        var cmb_servicios =$("#cmb_servicios").val();
        var cmb_terapeuta =$("#cmb_terapeuta").val();
        var sesiones_totales =$("#sesiones_totales").val();
        var sesiones_actuales =$("#sesiones_actuales").val();

        var cmb_servicios_glosa = $("#cmb_servicios option:selected").text();
        var cmb_terapeuta_glosa = $("#cmb_terapeuta option:selected").text();

        $.ajax({
            url: "../model/update_asignacion.php",
            type: "POST",
            dataType: 'json',
            data: {
                id: id_solicitud,
                cmb_servicios: cmb_servicios,
                cmb_terapeuta: cmb_terapeuta,
                sesiones_totales: sesiones_totales,
                sesiones_actuales: sesiones_actuales,
                cmb_servicios_glosa:cmb_servicios_glosa,
                cmb_terapeuta_glosa:cmb_terapeuta_glosa
            },
            success: function (data) {
                if (data.codigo == 2) {
                    Swal.fire({
                        title: 'Ha ocurrido un error',
                        text: data.mensaje,
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        timer: 1000,
                        onClose: () => {
                            Swal.close();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Solicitud Modificada correctamente',
                        icon: 'success',
                        text: data.mensaje,
                        confirmButtonText: 'Aceptar',
                        timer: 1000,
                        onClose: () => {
                            Swal.close();
                        }
                    });
                    LlenaSolicitudes();
                    $('#modal_asignar').modal('hide');
                }
            }
        });
    });

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
    



});