<?php
session_start();
require_once('../config/database.php');

$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset("utf8mb4");


$txt_nombre = $_POST['txt_nombre'];
$txt_rut = $_POST['txt_rut'];
$dt_nacimiento = $_POST['dt_nacimiento'];
$txt_email = $_POST['txt_email'];
$txt_fono = $_POST['txt_fono'];
$cmb_region = $_POST['cmb_region'];
$cmb_comuna = $_POST['cmb_comuna'];
$txt_sector = $_POST['txt_sector'];

$fecha_nacimiento = \DateTime::createFromFormat('d-m-Y', $dt_nacimiento);
$fecha_hoy = new \DateTime();
$interval = $fecha_hoy->diff($fecha_nacimiento);

$anos = $interval->format('%y');
$meses = $interval->format('%m');
$dias = $interval->format('%d');

$edad = $anos . ' años ' . $meses . ' meses ' ;

// echo $edad;
// exit();

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->begin_transaction();

try {
    $sql = "INSERT INTO solicitudes (nombre,edad, rut, fecha_nacimiento, email, fono, region, comuna,sector, estado, fecha_soliciud) 
    VALUES ('{$txt_nombre}','{$edad}', '{$txt_rut}', STR_TO_DATE('{$dt_nacimiento}', '%d-%m-%Y') , '{$txt_email}', '{$txt_fono}', '{$cmb_region}', '{$cmb_comuna}','{$txt_sector}', 0, now())";

    if (!$conn->query($sql)) {
        throw new Exception("Error al insertar en lista_espera: " . $conn->error);
    }
   
    $conn->commit();
    echo json_encode(['codigo' => 0, 'mensaje' => 'Felicidades ya diste el primer paso, nos pondremos en contacto a la brevedad posible al correo electronico registrado en el formulario']);

} catch (Exception $e) {
    
    $conn->rollback();
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al crear el registro', 'error' => $conn->error]);
}

?>
