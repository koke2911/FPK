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
$sql = "SELECT s.id as ID,
                l.id as ID_LE, 
                s.nombre as NOMBRE,
                s.rut as RUT,
                s.edad as EDAD,
                l.nombre_responsable as NOMBRE_RESPONSABLE,
                s.email as EMAIL,
                l.fono as FONO,
                ifnull(s.comuna,'-')  as COMUNA,
                l.direccion as DIRECCION,
                l.fecha as FECHA_SOLICITUD,
                e.glosa as ESTADO
                from solicitudes s 
                inner join lista_espera l on l.id_solicitud=s.id
                inner join estados_le e on e.id=l.estado
                where s.estado=2  and l.estado in (0,1,2,3,5) order by s.id desc";
$result = $conn->query($sql);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'ID' => $row['ID'],
            'ID_LE' => $row['ID_LE'],
            'NOMBRE' => $row['NOMBRE'],
            'RUT' => $row['RUT'],
            'EDAD' => $row['EDAD'],
            'NOMBRE_RESPONSABLE' => $row['NOMBRE_RESPONSABLE'],
            'EMAIL' => $row['EMAIL'],
            'FONO' => $row['FONO'],
            'COMUNA' => $row['COMUNA'],
            'DIRECCION' => $row['DIRECCION'],
            'FECHA_SOLICITUD' => $row['FECHA_SOLICITUD'],
            'ESTADO' => $row['ESTADO']
        ];
    }
}
// print_r($filas);


echo json_encode(['data' => $filas]);
