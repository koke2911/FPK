<?php
session_start();
require_once('../config/database.php');
$usuario = $_SESSION['id_usuario'];

$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset("utf8mb4");

$id = $_POST['id'];
$rut = $_POST['rut'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$profesion = $_POST['profesion'];
$estado = $_POST['estado'];

$conn->begin_transaction();

try {

    if($id!=""){

        $sql = "UPDATE  profesionales SET rut='$rut',nombre='$nombre',apellido='$apellido',profesion_id=$profesion,estado=$estado WHERE id=$id";
    }else{

        $sql = "INSERT INTO  profesionales (rut,nombre,apellido,profesion_id,estado) values('$rut','$nombre','$apellido',$profesion,$estado);";
    }

    if (!$conn->query($sql)) {
        throw new Exception("Error al insertar en lista_espera: " . $conn->error);
    }

  

    $conn->commit();
    echo json_encode(['codigo' => 0, 'mensaje' => 'Solicitud actualizada con exito']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error en el proceso', 'error' => $e->getMessage()]);
}
