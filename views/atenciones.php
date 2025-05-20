<?php
session_start();

$rut_usuario = $_SESSION['rut_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];

if (empty($_SESSION)) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Kids</title>
    <link rel="stylesheet" href="../public/libreries/bootstrap-4.6/bootstrap.min.css">
    <link rel="stylesheet" href="../public/libreries/vendor/datepicker/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="../public/libreries/vendor/datatables/dataTables.cellEdit.css">
    <link href="../public/libreries/js/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="../public/css/stylePrincipal.css">
    <script src="../public/libreries/js/fontawesome.all.js" crossorigin="anonymous"></script>

</head>

<body>
    <h2 class="text-center">Solicitudes en atención</h2>

    <div class="modal fade" id="modal_estado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar estado de la solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="estado">Estado</label>
                            <select id="cmb_estado" name="id=" estado"" class="form-control">
                                <option value="">Seleccione</option>
                                <option value="1">En Lista de Espera</option>
                                <!-- <option value="1">Correo enviado</option> -->
                                <!-- <option value="2">Seguimiento Whatsapp</option> -->
                                <!-- <option value="3">Terapeuta designada</option> -->
                                <option value="4">Proceso completado</option>
                                <!-- <option value="5">No contesto correo</option> -->
                                <option value="6">No siguio el proceso</option>
                                <!-- <option value="7">En atencion</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="observacion">Observaci n</label>
                            <textarea id="observacion" class="form-control" rows="3" maxlength="250"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_guardar_estado">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-2" style="margin-left: 10px;">
            <label for="buscadorTarjetas">Buscar:</label>
            <input type="text" id="buscadorTarjetas" class="form-control" placeholder="Buscar solicitud...">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-primary" id="btn_exportar_excel" style="margin-top: 30px"><i class="fas fa-file-excel"></i> Exportar</button>
        </div>
    </div>

    <div class="card shadow mb-12">
        <div class="card-body">
            <div id="cards_container" class="row g-3" style="max-height: 80vh; overflow-y: auto;margin-bottom: 20px;">
                <!-- Aquí se cargarán las tarjetas dinámicamente -->
            </div>
        </div>
    </div>

    <!-- <div class="row ">
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-12">
                <div class="card-body">
                    <div id="field_wrapper1">
                        <div class="row">
                            <div class="table-responsive" style="overflow-x: hidden;overflow-y:scroll;height: 80vh;padding:1em">
                                <table class="table table-bordered" width="100%" cellspacing="0" id="grid_solicitudes">
                                    <thead style="background: #2f2744;color: #FFF;">
                                        <tr>
                                            <th>#ID</th>
                                            <th>Nombre</th>
                                            <th>Rut</th>
                                            <th>Edad</th>
                                            <th>Responsable</th>
                                            <th>email</th>
                                            <th>Fono</th>
                                            <th>Comuna</th>
                                            <th>Dirección</th>
                                            <th>Fecha</th>
                                            <th>Estado</th>
                                            <th>Traza</th>

                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="modal fade" id="modal_asignar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Asignaciones a solicitud</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="cmb_servicios">Servicios</label>
                            <select id="cmb_servicios" name="cmb_servicios" class="form-control"></select>
                        </div>
                        <div class="col-md-6">
                            <label for="cmb_terapeuta">Terapeuta</label>
                            <select id="cmb_terapeuta" name="cmb_terapeuta" class="form-control"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="sesiones_totales">Sesiones totales</label>
                            <input type="number" id="sesiones_totales" name="sesiones_totales" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="sesiones_actuales">Sesiones actuales</label>
                            <input type="number" id="sesiones_actuales" name="sesiones_actuales" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn_guarda_asingacion">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../public/libreries/bootstrap-4.6/jquery-3.6.0.min.js"></script>
    <script src="../public/libreries/bootstrap-4.6/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datepicker/moment.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datepicker/bootstrap-datetimepicker.es.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/dataTables.select.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/buttons.print.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/buttons.colVis.min.js"></script>

    <script type="text/javascript" src="../public/libreries/vendor/datatables/jszip.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/pdfmake.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/vfs_fonts.js"></script>

    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/fnReloadAjax.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.cellEdit.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/fnFindCellRowNodes.js"></script>
    <script type="text/javascript" src="../public/libreries/js/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="../public/libreries/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/bootstrap-select/js/bootstrap-select.min.js"></script>


    <script type="text/javascript" src="../public/js/atenciones.js"></script>

</body>

</html>