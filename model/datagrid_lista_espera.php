<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];
$port = $_SESSION['port'];
error_reporting(0);


$conn = new mysqli($servername, $username, $password, $dbname,$port);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$cmb_whatsapp = $_GET['cmb_whatsapp'];
$cmb_reunion = $_GET['cmb_reunion'];
$cmb_pago = $_GET['cmb_pago'];
$cmb_profesional = $_GET['cmb_profesional'];


// $estado = $_GET['estado'];


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
                se.nombre as SERVICIO ,
                IFNULL(l.servicio_id, 0) as SERVICIO_ID,
                IFNULL(l.profesional_id, 0) as PROFESIONAL_ID,
                IFNULL(l.sesiones_totales, 0) as SESIONES_TOTALES,
                IFNULL(l.sesiones_actuales, 0) as SESIONES_ACTUALES,
                IFNULL(concat(p.nombre,' ',p.apellido),'-') as NOMBRE_PROFESIONAL,
                IFNULL(concat(sesiones_actuales,' de ',sesiones_totales),'-') as SESIONES
                from solicitudes s 
                inner join lista_espera l on l.id_solicitud=s.id
                inner join estados_le e on e.id=l.estado
                inner join comunas c on c.id=s.comuna
                left join servicios se on se.id=l.servicio_id
                left join profesionales p on p.id=l.profesional_id
                where s.estado=2  and l.estado in (0,1,2,3,5) ";

                if($cmb_whatsapp!=""){
                    if($cmb_whatsapp==1){
                        $sql.=" and IFNULL(whatsapp,'false')='true'";
                    }else if($cmb_whatsapp==0){
                        $sql.=" and IFNULL(whatsapp,'false')='false'";
                    }                
                }

                if($cmb_reunion!=""){
                    if($cmb_reunion==1){
                        $sql.=" and IFNULL(reunion,'false')='true'";
                    }else if($cmb_reunion==0){
                        $sql.=" and IFNULL(reunion,'false')='false'";
                    }                
                }

                if($cmb_pago!=""){
                    if($cmb_pago==1){
                        $sql.=" and IFNULL(mensualidad,'false')='true'";
                    }else if($cmb_pago==0){
                        $sql.=" and IFNULL(mensualidad,'false')='false'";
                    }                
                }

                if($cmb_profesional!="null" && $cmb_profesional!="-"){
                    $sql.=" and l.profesional_id=".$cmb_profesional." ";
                }

       

                $sql.="order by s.id asc";
// echo $sql;

$result = $conn->query($sql);

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
            'NOMBRE_PROFESIONAL'=>($row['NOMBRE_PROFESIONAL']),
            'SESIONES'=>($row['SESIONES'])
        ];
    }
}
// print_r($filas);
if(empty($filas)){
    echo json_encode(['data' => '']);
}else{

    echo json_encode(['data' => $filas]);
}

