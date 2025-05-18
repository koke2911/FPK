<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];

$conn = new mysqli($servername, $username, $password, $dbname,$port);
$region_id=$_GET['region'];
$condicion='';

if($region_id!=0){
    $condicion= " where codigo_region='$region_id' "; 
}

$sql=" SELECT * FROM comunas  $condicion";

// echo $sql;

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'CODIGO' => utf8_encode($row['id']),
            'NOMBRE' => utf8_encode($row['nombre'])            
        ];
    }
}

if(empty($filas)){
    echo json_encode([]);
}else{

    echo json_encode( $filas);
}