<?php
session_start();

$usuario = $_SESSION['id_usuario'];

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];

// exit();

$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset("utf8mb4");

// Verifica conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Parámetros
$id = $_POST['id'];
$cmb_servicios = $_POST['cmb_servicios'];
$cmb_terapeuta = $_POST['cmb_terapeuta'];
$sesiones_totales = $_POST['sesiones_totales'];
$sesiones_actuales = $_POST['sesiones_actuales'];

$cmb_servicios_glosa=$_POST['cmb_servicios_glosa'];
$cmb_terapeuta_glosa=$_POST['cmb_terapeuta_glosa'];

if($cmb_terapeuta==""){
    $cmb_terapeuta='null';
}


$observacion="Profesional: ". $cmb_terapeuta_glosa." Sesiones totales: ". $sesiones_totales." Sesiones actuales: ". $sesiones_actuales." Servicio: ". $cmb_servicios_glosa;
// Iniciar transacción
$conn->begin_transaction();

try {
    // Actualiza el estado
    $sql = "UPDATE lista_espera set profesional_id=$cmb_terapeuta, sesiones_totales=$sesiones_totales , sesiones_actuales=$sesiones_actuales,servicio_id=$cmb_servicios where id_solicitud=$id";
    // echo $sql;
    if (!$conn->query($sql)) {
        throw new Exception("Error en UPDATE: " . $conn->error);
    }

    // Inserta en la traza
    $sql2 = "INSERT INTO lista_espera_traza (id_solicitud, estado, observacion, fecha, usuario) 
             VALUES ($id, 15, '$observacion', NOW(), '$usuario')";
    if (!$conn->query($sql2)) {
        throw new Exception("Error en INSERT: " . $conn->error);
    }

    // Si todo fue exitoso
    $conn->commit();
    echo json_encode(['codigo' => 0, 'mensaje' => 'Has modificado la solicitud #' . $id]);
} catch (Exception $e) {
    // Si algo falla, se revierte todo
    $conn->rollback();
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al procesar la solicitud', 'error' => $e->getMessage()]);
}

$conn->close();
