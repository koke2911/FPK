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
                e.glosa as ESTADO,
                IFNULL(whatsapp,false) as WHATSAPP,
                IFNULL(reunion,false) as REUNION,
                IFNULL(mensualidad,false) as MENSUALIDAD,
                se.nombre as SERVICIO ,
                IFNULL(l.servicio_id, 0) as SERVICIO_ID,
                IFNULL(l.profesional_id, 0) as PROFESIONAL_ID,
                IFNULL(l.sesiones_totales, 0) as SESIONES_TOTALES,
                IFNULL(l.sesiones_actuales, 0) as SESIONES_ACTUALES,
                concat(p.nombre,' ',p.apellido) as NOMBRE_PROFESIONAL,
                concat(sesiones_actuales,' de ',sesiones_totales) as SESIONES
                from solicitudes s 
                inner join lista_espera l on l.id_solicitud=s.id
                inner join estados_le e on e.id=l.estado
                inner join comunas c on c.id=s.comuna
                left join servicios se on se.id=l.servicio_id
                left join profesionales p on p.id=l.profesional_id
                where s.estado=2  and l.estado in (4,6) order by s.id desc";
$result = $conn->query($sql);

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
            'DIRECCION' => ($row['DIRECCION']),
            'FECHA_SOLICITUD' => utf8_encode($row['FECHA_SOLICITUD']),
            'ESTADO' => utf8_encode($row['ESTADO']),
            'WHATSAPP' => utf8_encode($row['WHATSAPP']),
            'REUNION' => utf8_encode($row['REUNION']),
            'MENSUALIDAD' => utf8_encode($row['MENSUALIDAD']),
            'SERVICIO' => utf8_encode($row['SERVICIO']),
            'SERVICIO_ID' => utf8_encode($row['SERVICIO_ID']),
            'PROFESIONAL_ID' => utf8_encode($row['PROFESIONAL_ID']),
            'SESIONES_TOTALES' => utf8_encode($row['SESIONES_TOTALES']),
            'SESIONES_ACTUALES' => utf8_encode($row['SESIONES_ACTUALES']),
            'NOMBRE_PROFESIONAL' => utf8_encode($row['NOMBRE_PROFESIONAL']),
            'SESIONES' => utf8_encode($row['SESIONES'])
        ];
    }
}
// print_r($filas);


echo json_encode(['data' => $filas]);
