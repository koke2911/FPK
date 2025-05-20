<?php
session_start();
require_once('../config/database.php');
$usuario=$_SESSION['id_usuario'];

$conn = new mysqli($servername, $username, $password, $dbname,$port);
$conn->set_charset("utf8mb4");

$id = $_POST['id'];
$estado = $_POST['estado'];
$observacion = $_POST['observacion'];


$conn->begin_transaction();

try {
        $sql = "INSERT INTO lista_espera_traza (id_solicitud, estado, observacion, fecha, usuario) VALUES ($id, $estado, '$observacion', now(), '$usuario')";

        if (!$conn->query($sql)) {
            throw new Exception("Error al insertar en lista_espera: " . $conn->error);
        }
        
        $sql2 = "UPDATE lista_espera SET estado=$estado WHERE id_solicitud=$id";
        if (!$conn->query($sql2)) {
            throw new Exception("Error al insertar en lista_espera: " . $conn->error);
        }

        $conn->commit();
        echo json_encode(['codigo' => 0, 'mensaje' => 'Solicitud actualizada con exito']);
            
       
}catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error en el proceso', 'error' => $e->getMessage()]);
}
