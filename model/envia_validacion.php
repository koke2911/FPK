<?php

require_once('../config/database.php');

$conn = new mysqli($servername, $username, $password, $dbname);

$id = $_POST['id'];
$txt_nombre = $_POST['txt_nombre'];
$txt_edad = $_POST['txt_edad'];
$txt_rut = $_POST['txt_rut'];
$txt_direccion = $_POST['txt_direccion'];
$txt_nombre_adulto = $_POST['txt_nombre_adulto'];
$txt_fono = $_POST['txt_fono'];
$txt_email = $_POST['txt_email'];

require("../public/libreries/PHPMailer/src/PHPMailer.php");
require("../public/libreries/PHPMailer/src/SMTP.php");
require("../public/libreries/PHPMailer/src/Exception.php");
use PHPMailer\PHPMailer\PHPMailer;

function enviaCorreo($id, $txt_email,$conn){

    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'sistemas@saludohiggins.cl';
        $mail->Password = 'zqucioripnjvuqkd';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('koke1592@gmail.com', 'Fono Play Kids');
        $mail->addAddress('koke1592@gmail.com', 'Nombre Destino');

        $mail->isHTML(true);
        $mail->Subject = 'FonoPlayKids - Asegura un cupo con nosotros!!';
        $mail->Body = '$mensaje';


        if ($mail->send()) {
            echo json_encode(['codigo' => 0, 'mensaje' => 'Felicidades ya diste el primer paso, nos pondremos en contacto a la brevedad posible al correo electronico registrado en el formulario']);
            exit();
        } else {
            echo json_encode(['codigo' => 2, 'mensaje' => 'No se ha podido enviar el correo de notificación', 'error' => $conn->error]);
            exit();
        }
    } catch (Exception $e) {
        echo json_encode(['codigo' => 2, 'mensaje' => 'Error al enviar el correo', 'error' => $conn->error]);
        exit();
    }

   
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql="SELECT id from solicitudes where md5(id)='$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $id=$row['id'];
}else{
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al actualizar solicitud', 'error' => $conn->error]);
    exit();
}


$sql = "SELECT id_solicitud from lista_espera where id_solicitud='$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
  
    echo json_encode(['codigo' => 2, 'mensaje' => 'Esta solicitud ya se encuentra en lista de espera, de no haber recibido el correo con la notificacion ponerse en contacto', 'error' => $conn->error]);
    exit();
} 


$sql = "INSERT INTO lista_espera(id_solicitud,nombre_responsable,fono,direccion,fecha,estado)values($id,'$txt_nombre_adulto','$txt_fono','$txt_direccion',now(),0)";
// echo $sql;
// exit();
$result = $conn->query($sql);

if ($result) {

    $sql2 = "UPDATE solicitudes set estado=2 where id='$id'";
    $result2 = $conn->query($sql2);

    if ($result2) {
        enviaCorreo($id, $txt_email,$conn);
       
    }else{
        echo json_encode(['codigo' => 2, 'mensaje' => 'Error al actualizar solicitud', 'error' => $conn->error]);
        exit();
    }

} else {
    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al asignar lista de espera', 'error' => $conn->error]);
    exit();
}
