<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];

$conn = new mysqli($servername, $username, $password, $dbname,$port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// echo 'aqui';
$sql = "SELECT s.id as ID,
                l.id as ID_LE, 
                s.nombre as NOMBRE,
                s.rut as RUT,
                s.edad as EDAD,
                l.nombre_responsable as NOMBRE_RESPONSABLE,
                s.email as EMAIL,
                l.fono as FONO,
                ifnull(c.nombre,'-')  as COMUNA,
                l.direccion as DIRECCION,
                l.fecha as FECHA_SOLICITUD,
                e.glosa as ESTADO
                from solicitudes s 
                inner join lista_espera l on l.id_solicitud=s.id
                inner join estados_le e on e.id=l.estado
                 inner join comunas c on c.id=s.comuna
                where s.estado=2  and l.estado in (7) order by s.id desc";
$result = $conn->query($sql);

// print_r($result);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'ID' => utf8_encode($row['ID']),
            'ID_LE' => utf8_encode($row['ID_LE']),
            'NOMBRE' => utf8_encode($row['NOMBRE']),
            'RUT' => utf8_encode($row['RUT']),
            'EDAD' => ($row['EDAD']),
            'NOMBRE_RESPONSABLE' => utf8_encode($row['NOMBRE_RESPONSABLE']),
            'EMAIL' => utf8_encode($row['EMAIL']),
            'FONO' => utf8_encode($row['FONO']),
            'COMUNA' => utf8_encode($row['COMUNA']),
            'DIRECCION' => utf8_encode($row['DIRECCION']),
            'FECHA_SOLICITUD' => utf8_encode($row['FECHA_SOLICITUD']),
            'ESTADO' => utf8_encode($row['ESTADO'])
        ];

        // print_r($filas);
    }
}
// print_r($filas);


echo json_encode(['data' => $filas]);
