<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];


$conn = new mysqli($servername, $username, $password, $dbname,$port);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$estado = $_GET['estado'];


// echo 'aqui';
$sql = "SELECT s.id as ID,s.nombre as NOMBRE,s.rut as RUT,s.edad as EDAD,s.email as EMAIL,s.fono as FONO,r.nombre as REGION,c.nombre as COMUNA,ifnull(s.sector,'-')  as SECTOR,s.fecha_soliciud  as FECHA_SOLICITUD,
ifnull(s.correo,'0') as CORREO 
from solicitudes s 
inner join regiones r on r.codigo=s.region
inner join comunas c on c.id=s.comuna where s.estado=$estado order by s.id asc";
$result = $conn->query($sql);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        

        $filas[] = [
            'ID' => utf8_encode($row['ID']),
            'NOMBRE' => ($row['NOMBRE']),
            'RUT' => utf8_encode($row['RUT']),
            'EDAD' => utf8_encode($row['EDAD']),
            'EMAIL' => utf8_encode($row['EMAIL']),
            'FONO' => utf8_encode($row['FONO']),
            'REGION' => ($row['REGION']) .' - '. $row['COMUNA'],
            // 'COMUNA' => ($row['COMUNA']),
            'SECTOR' => ($row['SECTOR']),
            'FECHA_SOLICITUD' => utf8_encode($row['FECHA_SOLICITUD']),
            'CORREO' => utf8_encode($row['CORREO'])
        ];
    }

}
// print_r($filas);

if(empty($filas)){
    echo json_encode(['data' => '']);
}else{
echo json_encode(['data' => $filas]);

}

