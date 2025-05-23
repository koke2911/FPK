<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];


$conn = new mysqli($servername, $username, $password, $dbname, $port);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $estado = $_GET['estado'];


// echo 'aqui';
$sql = "SELECT p.id as ID,
                rut as RUT,
                p.nombre as NOMBRE,
                apellido as APELLIDO,
                pr.nombre as PROFESION,
                profesion_id as PROFESION_ID,
                CASE p.estado
                        WHEN 0 THEN 'Inactivo'
                        WHEN 1 THEN 'Activo'
                        ELSE 'Desconocido'
                    END AS ESTADO,
                p.estado as ESTADO_COD 
                from profesionales p
                inner join profesiones pr on pr.id=p.profesion_id";
$result = $conn->query($sql);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'ID' => ($row['ID']),
            'RUT' => ($row['RUT']),
            'NOMBRE' => ($row['NOMBRE']),
            'APELLIDO' => ($row['APELLIDO']),
            'PROFESION' => ($row['PROFESION']),
            'PROFESION_ID' => ($row['PROFESION_ID']),
            'ESTADO' => ($row['ESTADO']),
            'ESTADO_COD' => ($row['ESTADO_COD'])
        ];
    }
}
// print_r($filas);
if (empty($filas)) {
    echo json_encode(['data' => '']);
} else {

    echo json_encode(['data' => $filas]);
}
