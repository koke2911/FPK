var id_solicitud;

function verTraza(id){
    $("#modal_ficha").modal('hide');
    window.location.href = "../views/ver_traza.php?id=" + id;
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


function cargaModal(ID) {
    id_solicitud = ID;
    $("#modal_ficha").modal('hide');
    $('#modal_estado').modal('show');
}

function registraCheck(id,checked,tipo){ // W R M

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
                LlenaTabla();
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
        $("#cmb_profesional").html('');
        

        // console.log('---'+data);

        regiones = '<option value="-"></option>';

        for (var i = 0; i < data.length; i++) {
            // console.log(data[i].CODIGO);
            regiones += "<option value=\"" + data[i].id + "\">" + data[i].nombre + "</option>";
        }

        $("#cmb_terapeuta").append(regiones);
        $("#cmb_profesional").append(regiones);
    });
}

function asignaOpciones(id,servicio_id,profesional_id,totales,actuales) {
    // console.log(servicio_id);
    // $('#modal_asignar').modal('show');
    id_solicitud = id;
    $('#cmb_servicios').val(servicio_id);
    $('#cmb_terapeuta').val(profesional_id);
    $('#sesiones_totales').val(totales);
    $('#sesiones_actuales').val(actuales);
    $("#modal_ficha").modal('hide');
    $('#modal_asignar').modal('show');
}


function LlenaSolicitudes() {


    var cmb_whatsapp=$("#cmb_whatsapp").val();
    var cmb_reunion=$("#cmb_reunion").val();
    var cmb_pago=$("#cmb_pago").val();
    var cmb_profesional=$("#cmb_profesional").val();

    $.ajax({
        url: "../model/datagrid_lista_espera.php?cmb_whatsapp="+cmb_whatsapp+"&cmb_reunion="+cmb_reunion+"&cmb_pago="+cmb_pago+"&cmb_profesional="+cmb_profesional,
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
                <div class="col-md-3 col-xl-3" style="margin-bottom: 20px;">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">#${row.ID} <strong>${row.NOMBRE}</strong> <br>${row.EDAD}</h5>
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
                                ${btnTraza }
                                
                                
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

function LlenaTabla() {
    var cmb_whatsapp = $("#cmb_whatsapp").val();
    var cmb_reunion = $("#cmb_reunion").val();
    var cmb_pago = $("#cmb_pago").val();
    var cmb_profesional = $("#cmb_profesional").val();

    $("#datatable").dataTable().fnReloadAjax("../model/datagrid_lista_espera.php?cmb_whatsapp=" + cmb_whatsapp + "&cmb_reunion=" + cmb_reunion + "&cmb_pago=" + cmb_pago + "&cmb_profesional=" + cmb_profesional);

   

}

function verFicha(data) {
    const container = $('#cards_containerL');
    container.empty();
    const btnAccion = `<button class="btn btn-success" onclick="cargaModal(${data.ID})" title="Cambiar estado"><i class="fa fa-book"></i></button>`;
    const btnAsignaServicio = `<button class="btn btn-warning" onclick="asignaOpciones(${data.ID},${data.SERVICIO_ID},${data.PROFESIONAL_ID},${data.SESIONES_TOTALES},${data.SESIONES_ACTUALES})" title="Asignaciones"><i class="fa fa-hospital"></i></button>`;
    let btnTraza = `<button class="btn btn-primary" onclick="verTraza(${data.ID})" title="Ver traza"><i class="fa fa-eye"></i></button>`;

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
                                <i class="fab fa-whatsapp"></i><strong> Contacto Whatsapp:</strong> <input type="checkbox" onclick="registraCheck(${data.ID}, this.checked,'W')" ${data.WHATSAPP == 'true' ? 'checked' : ''} ><br>
                                <i class="fas fa-video"></i><strong> Reunión OnLine:</strong> <input type="checkbox" onclick="registraCheck(${data.ID}, this.checked,'R')" ${data.REUNION == 'true' ? 'checked' : ''} ><br>
                                <i class="fas fa-money-bill-wave"></i><strong> Pago mensualidad:</strong> <input type="checkbox" onclick="registraCheck(${data.ID}, this.checked,'M')" ${data.MENSUALIDAD == 'true' ? 'checked' : ''} ><br>
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
    busca_fecha();
    LlenaSolicitudes();
    llenaServicios();
    llenaProfesionales();
    



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
                    // $("#grid_solicitudes").dataTable().fnReloadAjax("../model/datagrid_lista_espera.php");
                    LlenaSolicitudes();
                    LlenaTabla();
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

    $('#btn_guarda_asingacion').click(function () {
        var cmb_servicios = $("#cmb_servicios").val();
        var cmb_terapeuta = $("#cmb_terapeuta").val();
        var sesiones_totales = $("#sesiones_totales").val();
        var sesiones_actuales = $("#sesiones_actuales").val();

        $.ajax({
            url: "../model/update_asignacion.php",
            type: "POST",
            dataType: 'json',
            data: {
                id: id_solicitud,
                cmb_servicios: cmb_servicios,
                cmb_terapeuta: cmb_terapeuta,
                sesiones_totales: sesiones_totales,
                sesiones_actuales: sesiones_actuales
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
                    LlenaTabla();
                    $('#modal_asignar').modal('hide');
                }
            }
        });
    });

$('#cmb_whatsapp, #cmb_reunion, #cmb_pago, #cmb_profesional').change(function () {
    LlenaSolicitudes();
    LlenaTabla();
});


    $('#btn_limpiar').click(function () {
        $('#cmb_whatsapp').val('');
        $('#cmb_reunion').val('');
        $('#cmb_pago').val('');
        $('#cmb_profesional').val('');
        LlenaSolicitudes();
        LlenaTabla();
    });


    var datatable = $('#datatable').DataTable({
        "responsive": true,
        "paging": true,
        "destroy": true,
        // "ajax": "../model/datagrid_lista_espera.php?cmb_whatsapp=&cmb_reunion=&cmb_pago=&cmb_profesional=null",
        // data: response.data,
        columns: [
            { data: 'ID', title: 'ID' },
            { data: 'NOMBRE', title: 'Nombre' },
            { data: 'EDAD', title: 'Edad' },
            { data: 'RUT', title: 'RUT',visible: false },
            { data: 'NOMBRE_RESPONSABLE', title: 'Responsable' },
            { data: 'EMAIL', title: 'Email' },
            { data: 'FONO', title: 'Fono' },
            { data: 'COMUNA', title: 'Región-Comuna',visible:false },
            { data: 'DIRECCION', title: 'Sector', visible: false },
            { data: 'FECHA_SOLICITUD', title: 'Fecha Solicitud' },
            { data: 'SERVICIO', title: 'Servicio', visible: false },
            { data: 'SESIONES', title: 'Sesiones',visible:false },
            { data: 'NOMBRE_PROFESIONAL', title: 'Terapeuta',visible: false },
            {
                data: 'WHATSAPP',
                title: 'Contacto Whatsapp',
                render: function (data, type, row) {
                    return data == 'true' ? `<input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'W')" checked> Si</input>` : `<input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'W')"> No</input>`;
                }
            },
            {
                data: 'REUNION',
                title: 'Reunión OnLine',
                render: function (data, type, row) {
                    return data == 'true' ? `<input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'R')" checked> Si</input>` : `<input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'R')"> No</input>`;
                }
            },
            {
                data: 'MENSUALIDAD',
                title: 'Pago mensualidad',
                render: function (data, type, row) {
                    return data == 'true' ? `<input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'M')" checked> Si</input>` : `<input type="checkbox" onclick="registraCheck(${row.ID}, this.checked,'M')"> No</input>`;
                }
            },
            {
                data: null,
                title: 'Acciones',
                render: function (data, type, row) {
                    const btnAccion = `<button class="btn btn-sm btn-success" onclick="cargaModal(${row.ID})" title="Cambiar estado"><i class="fa fa-book"></i></button>`;
                    const btnAsignaServicio = `<button class="btn btn-sm btn-warning" onclick="asignaOpciones(${row.ID},${row.SERVICIO_ID},${row.PROFESIONAL_ID},${row.SESIONES_TOTALES},${row.SESIONES_ACTUALES})" title="Asignaciones"><i class="fa fa-hospital"></i></button>`;
                    const btnTraza = `<button class="btn btn-sm btn-primary" onclick="verTraza(${row.ID})" title="Ver traza"><i class="fa fa-eye"></i></button>`;
                    const verficha = `<button type="button" class="btn btn-sm btn-primary ver-ficha"  title="Ver ficha"><i class="fa fa-file-text" aria-hidden="true"></i></button>`;
                    return `${verficha}`;
                }
            }
        ],
        destroy: true,
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

    LlenaTabla();

    $('#datatable').on('click', '.ver-ficha', function () {
        const table = $('#datatable').DataTable();

        // Obtener la fila a la que pertenece el botón clickeado
        const rowData = table.row($(this).closest('tr')).data();

        // console.log("Fila completa:", rowData);

        verFicha(rowData);
    });



   
});

// whatsapp
// reunion
// mensualidad