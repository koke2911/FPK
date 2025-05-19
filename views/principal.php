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
    <!-- <header class="navbar navbar-expand-lg shadow">
        <div class="container-fluid d-flex justify-content-between">
            <a class="navbar-brand" href="#" style="padding-right: 20px;"><i class="fas fa-bars me-2" id="ocultarBarraLateral" style="padding-right: 20px;"></i>FonoPlayKids <i class="fas fa-bell me-2" style="padding-right: 20px;color:#1abc9c"></i></a>
            <span><?php echo strtoupper($nombre_usuario . ' | ' . $rut_usuario); ?></span>
            <div>
                <button class="btn btn-outline-light me-2" id="miPerfil"><i class="fas fa-user"></i> Mi Perfil</button>
                <button class="btn btn-danger" id="cerrarSesion"><i class="fas fa-power-off"></i></button>
            </div>
        </div>
    </header>

    <div class="d-flex" style="min-height: calc(100vh - 60px);">
        <nav>
            <button id="menu_solicitudes"><i class="fas fa-users me-2"></i> Solicitudes</button>
            <button id="menu_rechazadas"><i class="fas fa-user-times me-2"></i> Rechazadas</button>
            <button id="menu_listaE"><i class="fas fa-list me-2"></i> L. Espera</button>
            <button id="menu_atencion"><i class="fas fa-medkit me-2"></i> En Proceso</button>
            <button id="menu_finish"><i class="fas fa-lock me-2"></i>Finalizados</button>
           
        </nav>

        <main>
            <iframe src="" id="principal"></iframe>
        </main>
    </div> -->

    <header class="navbar navbar-expand-lg shadow" style="background-color: #2f2744;">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-white" href="#">
                <i class="fas fa-bars me-2" id="ocultarBarraLateral" style="cursor: pointer;"></i>
                FonoPlayKids
            </a>
            <span class="text-white"><?php echo strtoupper($nombre_usuario . ' | ' . $rut_usuario); ?></span>
            <div>
                <button class="btn btn-outline-light me-2" id="miPerfil">
                    <i class="fas fa-user me-1"></i>Mi Perfil
                </button>
                <button class="btn btn-danger" id="cerrarSesion">
                    <i class="fas fa-power-off"></i>
                </button>
            </div>
        </div>
    </header>

    <div class="d-flex" >
        <nav class="sidebar">
            <ul>
                <li><button id="menu_solicitudes"><i class="fas fa-users me-2"></i> Solicitudes</button></li>
                <li><button id="menu_rechazadas"><i class="fas fa-user-times me-2"></i> Rechazadas</button></li>
                <li><button id="menu_listaE"><i class="fas fa-list me-2"></i> Lista Espera</button></li>
                <li><button id="menu_atencion"><i class="fas fa-medkit me-2"></i> En Proceso</button></li>
                <li><button id="menu_finish"><i class="fas fa-lock me-2"></i> Finalizados</button></li>
            </ul>
        </nav>

        <main>
            <iframe src="" id="principal"></iframe>
        </main>
    </div>



    <script src="../public/libreries/bootstrap-4.6/jquery-3.6.0.min.js"></script>
    <script src="../public/libreries/bootstrap-4.6/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datepicker/moment.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datepicker/bootstrap-datetimepicker.es.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/dataTables.select.min.js"></script>

    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.responsive.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/fnReloadAjax.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/dataTables.cellEdit.js"></script>
    <script type="text/javascript" src="../public/libreries/vendor/datatables/fnFindCellRowNodes.js"></script>
    <script type="text/javascript" src="../public/libreries/js/jquery-validation/dist/jquery.validate.js"></script>
    <script type="text/javascript" src="../public/libreries/js/sweetalert2/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/Multiple-Select/dist/js/bootstrap-multiselect.min.js"></script>
    <script type="text/javascript" src="../public/libreries/js/bootstrap-select/js/bootstrap-select.min.js"></script>


    <script type="text/javascript" src="../public/js/principal.js"></script>

</body>

</html>