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
                s.fecha_soliciud as FECHA_SOLICITUD,
                e.glosa as ESTADO,                
                IFNULL(whatsapp,false) as WHATSAPP,
                IFNULL(reunion,false) as REUNION,
                IFNULL(mensualidad,false) as MENSUALIDAD,
                se.nombre as SERVICIO,
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
                where s.estado=2  and l.estado in (7) order by s.id asc";
$result = $conn->query($sql);

// print_r($result);

$filas = [];


if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        $filas[] = [
            'ID' => ($row['ID']),
            'ID_LE' => ($row['ID_LE']),
            'NOMBRE' => ($row['NOMBRE']),
            'RUT' => ($row['RUT']),
            'EDAD' => ($row['EDAD']),
            'NOMBRE_RESPONSABLE' => ($row['NOMBRE_RESPONSABLE']),
            'EMAIL' => ($row['EMAIL']),
            'FONO' => ($row['FONO']),
            'COMUNA' => ($row['COMUNA']),
            'DIRECCION' => ($row['DIRECCION']),
            'FECHA_SOLICITUD' => ($row['FECHA_SOLICITUD']),
            'ESTADO' => ($row['ESTADO']),
            'WHATSAPP' => ($row['WHATSAPP']),
            'REUNION' => ($row['REUNION']),
            'MENSUALIDAD' => ($row['MENSUALIDAD']),
            'SERVICIO' => ($row['SERVICIO']),
            'SERVICIO_ID' => ($row['SERVICIO_ID']),
            'PROFESIONAL_ID' => ($row['PROFESIONAL_ID']),
            'SESIONES_TOTALES' => ($row['SESIONES_TOTALES']),
            'SESIONES_ACTUALES' => ($row['SESIONES_ACTUALES']),
            'NOMBRE_PROFESIONAL' => ($row['NOMBRE_PROFESIONAL']),
            'SESIONES' => ($row['SESIONES'])
        ];

        // print_r($filas);
    }
}
// print_r($filas);


echo json_encode(['data' => $filas]);
