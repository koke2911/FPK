<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];

// print_r($_SESSION);

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$estado = $_GET['estado'];


// echo 'aqui';
$sql = "SELECT s.id as ID,s.nombre as NOMBRE,s.rut as RUT,s.edad as EDAD,s.email as EMAIL,s.fono as FONO,r.nombre as REGION,c.nombre as CIUDAD,ifnull(s.comuna,'-')  as COMUNA,s.fecha_soliciud  as FECHA_SOLICITUD,
ifnull(s.correo,'0') as CORREO 
from solicitudes s 
inner join regiones r on r.codigo=s.region
inner join ciudades c on c.codigo=s.ciudad where s.estado=$estado order by s.id desc";
$result = $conn->query($sql);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        

        $filas[] = [
            'ID' => $row['ID'],
            'NOMBRE' => $row['NOMBRE'],
            'RUT' => $row['RUT'],
            'EDAD' => $row['EDAD'],
            'EMAIL' => $row['EMAIL'],
            'FONO' => $row['FONO'],
            'REGION' => utf8_encode($row['REGION']),
            'CIUDAD' => $row['CIUDAD'],
            'COMUNA' => $row['COMUNA'],
            'FECHA_SOLICITUD' => $row['FECHA_SOLICITUD'],
            'CORREO' => $row['CORREO']
        ];
    }

}
// print_r($filas);


echo json_encode(['data' => $filas]);
