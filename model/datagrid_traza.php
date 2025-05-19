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

$id = $_GET['id'];


$sql = "SELECT e.glosa as estado,
            date_format(fecha,'%d-%m-%Y %h:%m') as fecha,
            ifnull(observacion,'--') as observacion,
            concat(u.nombre,' ',u.apellidos) as usuario 
            from lista_espera_traza t 
                        inner join estados_le e on e.id=t.estado
                        inner join usuarios u on u.id=t.usuario
                        where t.id_solicitud=$id order by t.id desc";
$result = $conn->query($sql);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'ESTADO' => utf8_encode($row['estado']),
            'FECHA' => ($row['fecha']),
            'OBSERVACION' => utf8_encode($row['observacion']),
            'USUARIO' => ($row['usuario'])
        ];
    }
}
// print_r($filas);

if (empty($filas)) {
    echo json_encode(['data' => '']);
} else {
    echo json_encode(['data' => $filas]);
}
