<?php
session_start();

$rut_usuario = $_SESSION['rut_usuario'];
$nombre_usuario = $_SESSION['nombre_usuario'];
$estado = $_GET['estado'];

if ($estado == 0) {
    $glosa_estado = 'Recibidas';
} else {
    $glosa_estado = 'Rechazadas';
}

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

<body style="overflow-x: hidden">
    <input type="hidden" id="estado" value="<?php echo $estado; ?>">
    <!-- <h2 class="text-center">Solicitudes <?php echo $glosa_estado; ?></h2> -->

    <div class="row xs-12">
        <div class="col-md-12" ">
            <label for="buscadorTarjetas">Buscar:</label>
            <input type="text" id="buscadorTarjetas" class="form-control" placeholder="Buscar solicitud...">
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
                                            <th>email</th>
                                            <th>Fono</th>
                                            <th>Region-Comuna</th>                                            
                                            <th>Fecha</th>
                                            <th>Enviar</th>
                                            <th>Accion</th>                                            
                                            <th>Correo</th>
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


    <script type="text/javascript" src="../public/js/solicitudes.js"></script>

</body>

</html>