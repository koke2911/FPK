<?php
session_start();
require_once('../config/database.php');

$conn = new mysqli($servername, $username, $password, $dbname);

$txt_nombre = $_POST['txt_nombre'];
$txt_rut = $_POST['txt_rut'];
$txt_edad = $_POST['txt_edad'];
$txt_email = $_POST['txt_email'];
$txt_fono = $_POST['txt_fono'];
$cmb_region = $_POST['cmb_region'];
$cmb_ciudad = $_POST['cmb_ciudad'];
$cmb_comuna = $_POST['cmb_comuna'];



if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "INSERT INTO solicitudes (nombre, rut, edad, email, fono, region, ciudad, comuna, estado, fecha_soliciud) 
VALUES ('{$txt_nombre}', '{$txt_rut}', '{$txt_edad}', '{$txt_email}', '{$txt_fono}', '{$cmb_region}', '{$cmb_ciudad}', '{$cmb_comuna}', 0, now())";

$result = $conn->query($sql);

if ($result) {
    echo json_encode(['codigo' => 0, 'mensaje' => 'Felicidades ya diste el primer paso, nos pondremos en contacto a la brevedad posible al correo electronico registrado en el formulario']);
} else {
    echo json_encode(['codigo' => -1, 'mensaje' => 'Error al crear el registro', 'error' => $conn->error]);

}



