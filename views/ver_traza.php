<?php
session_start();

$id = $_GET['id'];

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
    <link rel="stylesheet" href="../public/libreries/vendor/datatables/dataTables.cellEdit.css">
    <script src="../public/libreries/js/fontawesome.all.js" crossorigin="anonymous"></script>

</head>
<!-- <input type="text" id="id" value="<?php echo $id; ?>"> -->

<body>
    <div class="container mt-4">
        <h3>Traza de Solicitud #<input type="text" id="id" value="<?php echo $id; ?>" disabled style="width: 40px;"></h3>


        <div class="table-responsive" style="overflow-x: hidden;overflow-y:scroll;height: 80vh;padding:1em">
            <table class="table table-bordered" width="100%" cellspacing="0" id="grid_solicitudes">
                <thead style="background: #2f2744;color: #FFF;">
                    <tr>
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Observación</th>
                        <th>Usuario</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../public/libreries/bootstrap-4.6/jquery-3.6.0.min.js"></script>
    <script src="../public/libreries/bootstrap-4.6/bootstrap.bundle.min.js"></script>
    <script src="../public/libreries/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/dataTables.select.min.js"></script>

    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/fnReloadAjax.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.cellEdit.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/fnFindCellRowNodes.js"></script>
    <script src="../public/js/traza.js"></script>
</body>

</html>