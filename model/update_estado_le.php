<?php
session_start();
require_once('../config/database.php');
$usuario=$_SESSION['id_usuario'];

$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_POST['id'];
$estado = $_POST['estado'];
$observacion = $_POST['observacion'];

$sql = "INSERT INTO lista_espera_traza (id_solicitud, estado, observacion, fecha, usuario) VALUES ($id, $estado, '$observacion', now(), '$usuario')";

$result = $conn->query($sql);

if ($result) {
   
    $sql2 = "UPDATE lista_espera SET estado=$estado WHERE id_solicitud=$id";

    $result2= $conn->query($sql2);

    if($result2){
        echo json_encode(['codigo' => 0, 'mensaje' => 'Solicitud actualizada con exito']);
        exit();
    }else{
        echo json_encode(['codigo' => 2, 'mensaje' => 'Error al actualizar la solicitud', 'error' => $conn->error]);
        exit();
    }

} else {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al actualizar la solicitud', 'error' => $conn->error]);
    exit();
}
