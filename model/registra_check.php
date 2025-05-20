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
$id = $_POST['id'];
$tipo = $_POST['tipo'];
$checked=$_POST['checked'];


if($tipo=='W'){
    $estado_traza=12;
    $consulta= " whatsapp='$checked'"; 
}else if($tipo=='R'){
    $estado_traza=13;
    $consulta= " reunion='$checked'"; 
} else if ($tipo == 'M'){
    $estado_traza=14;
    $consulta= " mensualidad='$checked'";
}

if($checked=='true'){
    $obs='Marca';
}else{
    $obs='Desmarca';
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // Actualiza el estado
    $sql = "UPDATE lista_espera SET ". $consulta ."  WHERE id_solicitud= {$id}";
    // echo $sql;
    if (!$conn->query($sql)) {
        throw new Exception("Error en UPDATE: " . $conn->error);
    }

    // Inserta en la traza
    $sql2 = "INSERT INTO lista_espera_traza (id_solicitud, estado, observacion, fecha, usuario) 
             VALUES ($id, $estado_traza, '$obs', NOW(), '$usuario')";
    if (!$conn->query($sql2)) {
        throw new Exception("Error en INSERT: " . $conn->error);
    }
//  echo $sql2;
    // Si todo fue exitoso
    $conn->commit();
    echo json_encode(['codigo' => 0, 'mensaje' => 'Has registrado la accion #' . $id]);
} catch (Exception $e) {
    // Si algo falla, se revierte todo
    $conn->rollback();
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al procesar la solicitud', 'error' => $e->getMessage()]);
}

$conn->close();
