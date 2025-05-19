<?php
session_start();

$usuario = $_SESSION['id_usuario'];

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verifica conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Parámetros
$id = $_POST['id'];
$estado = $_POST['estado'];
$observacion = isset($_POST['observacion']) ? $conn->real_escape_string($_POST['observacion']) : ''; // Escapar observación

if ($estado == 0) {
    $estado = 1;
    $estadoTraza = 10;
} else {
    $estado = 0;
    $estadoTraza = 11;
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // Actualiza el estado
    $sql = "UPDATE solicitudes SET estado = $estado WHERE id = {$id}";
    if (!$conn->query($sql)) {
        throw new Exception("Error en UPDATE: " . $conn->error);
    }

    // Inserta en la traza
    $sql2 = "INSERT INTO lista_espera_traza (id_solicitud, estado, observacion, fecha, usuario) 
             VALUES ($id, $estadoTraza, '$observacion', NOW(), '$usuario')";
    if (!$conn->query($sql2)) {
        throw new Exception("Error en INSERT: " . $conn->error);
    }

    // Si todo fue exitoso
    $conn->commit();
    echo json_encode(['codigo' => 0, 'mensaje' => 'Has rechazado la solicitud de contacto #' . $id]);
} catch (Exception $e) {
    // Si algo falla, se revierte todo
    $conn->rollback();
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al procesar la solicitud', 'error' => $e->getMessage()]);
}

$conn->close();
