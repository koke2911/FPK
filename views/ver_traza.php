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
    <script src="../public/libreries/js/fontawesome.all.js" crossorigin="anonymous"></script>

</head>
<!-- <input type="text" id="id" value="<?php echo $id; ?>"> -->

<body>
    <div class="container mt-4">
        <h3>Traza de Solicitud #<input type="text" id="id" value="<?php echo $id; ?>" disabled style="width: 40px;"></h3>


        <table class="table table-bordered mt-3">
            <thead class="thead-dark">
                <tr>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Observación</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody id="tbodyTraza">
                <!-- Aquí van las filas -->
            </tbody>
        </table>
    </div>

    <!-- Scripts -->
    <script src="../public/libreries/bootstrap-4.6/jquery-3.6.0.min.js"></script>
    <script src="../public/libreries/bootstrap-4.6/bootstrap.bundle.min.js"></script>
    <script src="../public/libreries/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../public/js/traza.js"></script>
</body>

</html>