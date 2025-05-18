<?php

require_once('../config/database.php');



$conn = new mysqli($servername, $username, $password, $dbname,$port);

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
    require_once("../config/variables.php");

    $sql = "SELECT fecha from fecha_lista";

    $result = $conn->query($sql);

    // print_r($result);
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
            $fecha_lista= $row['fecha'];
        }
    }

    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $correo;
        $mail->Password = $pass;
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($correo, 'Fono Play Kids');
        $mail->addAddress($txt_email, 'Cliente');

        $mail->isHTML(true);
        $mail->Subject = 'FonoPlayKids - Felicidades ya entraste a nuestra lista de espera!!';
        $mail->Body = '<html>
            <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
                <p>Estimada familia,</p>

                <p>Queremos agradecerles sinceramente por su interés y preferencia por <strong>Fonoplay Kids</strong>. Es un honor para nosotras acompañar el desarrollo de sus hijos e hijas, y nos alegra contar con su apoyo en este camino.</p>

                <p>Actualmente, contamos con <strong>lista de espera</strong> para comenzar atenciones desde el <strong>'. $fecha_lista.'</strong>, pero no se preocupen, ya han asegurado un cupo y nos estaremos contactando a la brevedad posible.</p>

                <h3 style="color: #2c3e50;">📍 Importante a considerar:</h3>
                <ul>
                    <li>Las sesiones a domicilio en lugares alejados contemplan un <strong>costo adicional por traslado</strong>, calculado según los kilómetros de distancia.</li>
                    <li>El <strong>agendamiento es mensual</strong> y debe realizarse con anticipación para asegurar disponibilidad.</li>
                    <li>Los servicios de Fonoplay Kids pueden ser <strong>reembolsables</strong>. Para ello, deben contar con una <strong>derivación de su pediatra</strong> indicando necesidad de estimulación temprana o del lenguaje.</li>
                </ul>
                <p style="color: #e67e22;"><strong>⚠️ El reembolso depende exclusivamente de cada plan e Isapre, no de Fonoplay Kids.</strong></p>

                <p>El primer paso del proceso es una <strong>reunión online gratuita</strong>, donde podrán conocer a la terapeuta, resolver dudas y coordinar los pasos siguientes. Luego de eso, comenzamos con la primera sesión en casa.</p>

                <p>Por su tranquilidad, antes de iniciar se les enviará:</p>
                <ul>
                    <li>Currículum de la terapeuta</li>
                    <li>Certificado de antecedentes</li>
                    <li>Certificado de inhabilidades para trabajar con menores de edad</li>
                </ul>

                <p>Gracias nuevamente por confiar en nuestro equipo. <strong>¡Estamos felices de poder acompañarlos!</strong></p>

                <p>Con cariño,<br>
                <strong>El equipo de Fonoplay Kids</strong></p>
            </body>
            </html>';


        // Attach files to the email
        // $mail->addAttachment('../public/document/Nosotros.pdf', 'Nosotros.pdf');
        // $mail->addAttachment('../public/document/Tarifas.pdf', 'Tarifas.pdf');



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
