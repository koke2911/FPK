<?php
session_start();
require_once('../config/database.php');

$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_POST['id'];
$estado = $_POST['estado'];

if($estado==0){
    $estado=1;
}else{
    $estado=0;
}


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "UPDATE solicitudes set estado=$estado WHERE id={$id}";

$result = $conn->query($sql);

if ($result) {
    echo json_encode(['codigo' => 0, 'mensaje' => 'Has rechazado la solicitud de contacto #'.$id]);
} else {
    echo json_encode(['codigo' => -1, 'mensaje' => 'Error al rechazar el registro', 'error' => $conn->error]);
}
