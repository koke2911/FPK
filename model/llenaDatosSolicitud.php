<?php

require_once('../config/database.php');

$conn = new mysqli($servername, $username, $password, $dbname,$port);
$conn->set_charset("utf8mb4");

$id = $_POST['id'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT s.id as ID,s.nombre as NOMBRE,s.rut as RUT,s.edad as EDAD,s.email as EMAIL,s.fono as FONO,
ifnull(s.correo,'0') as CORREO 
from solicitudes s 
where md5(s.id)='$id'";
$result = $conn->query($sql);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'ID' => $row['ID'],
            'NOMBRE' => $row['NOMBRE'],
            'RUT' => $row['RUT'],
            'EDAD' => utf8_encode($row['EDAD']),
            'EMAIL' => $row['EMAIL'],
            'FONO' => $row['FONO'],
            // 'REGION' => utf8_encode($row['REGION']),
            // 'CIUDAD' => $row['CIUDAD'],
            // 'COMUNA' => $row['COMUNA'],
            // 'FECHA_SOLICITUD' => $row['FECHA_SOLICITUD'],
            'CORREO' => $row['CORREO']
        ];
    }
}
// print_r($filas);


echo json_encode(['data' => $filas]);
