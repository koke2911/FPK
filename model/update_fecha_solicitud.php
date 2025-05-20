<?php
session_start();
require_once('../config/database.php');

$conn = new mysqli($servername, $username, $password, $dbname,$port);
$conn->set_charset("utf8mb4");

$fecha = $_POST['fecha'];



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "UPDATE fecha_lista set fecha='$fecha'";

$result = $conn->query($sql);

if ($result) {
    echo json_encode(['codigo' => 0, 'mensaje' => 'Fecha actualizada']);
} else {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al crear fecha', 'error' => $conn->error]);
}
