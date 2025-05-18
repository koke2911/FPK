<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];


$conn = new mysqli($servername, $username, $password, $dbname,$port);

$sql="SELECT * FROM regiones where estado=1";

$result = $conn->query($sql);

// $filas = [];

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'CODIGO' => utf8_encode($row['codigo']),
            'NOMBRE' => utf8_encode($row['nombre'])
            
        ];
    }
}
// print_r($filas);

if(empty($filas)){
    echo json_encode([]);
}else{

    echo json_encode( $filas);
}