<?php
session_start();

$servername = $_SESSION['servername'];
$username = $_SESSION['username'];
$password = $_SESSION['password'];
$dbname = $_SESSION['dbname'];

$id=$_POST['id'];

require_once("../public/libreries/PHPMailer/src/PHPMailer.php");
require_once("../public/libreries/PHPMailer/src/SMTP.php");
require_once("../public/libreries/PHPMailer/src/Exception.php");


$conn = new mysqli($servername, $username, $password, $dbname);

use PHPMailer\PHPMailer\PHPMailer;

$sql = "SELECT correo from solicitudes where id=$id and estado=0";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $filas[] = $row;
}

// print_r($filas[0]['correo']);
// exit();

if($filas[0]['correo']>0){
    echo json_encode(['codigo' => 2, 'mensaje' => 'Ya se envio el correo a esta solicitud', 'error' => $conn->error]);
    exit();
}



$sql = "SELECT s.id as ID,s.nombre as NOMBRE,s.rut as RUT,s.edad as EDAD,s.email as EMAIL,s.fono as FONO,r.nombre as REGION,c.nombre as CIUDAD,ifnull(s.comuna,'-')  as COMUNA,s.fecha_soliciud  as FECHA_SOLICITUD 
from solicitudes s 
inner join regiones r on r.codigo=s.region
inner join ciudades c on c.codigo=s.ciudad where id=$id";
$result = $conn->query($sql);

$filas = [];

$id_encript = md5($id);

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        
        $filas[] = $row;    
    }
    $email=$filas[0]['EMAIL'];
    // exit();
    $mensaje= ' <html>
                <head>
                <title>Confirmación de contacto - Fono Play Kids</title>
                </head>
                <body>
                <p><strong>¡Felicidades!</strong></p>                
                <p>Te has puesto en contacto con <strong>Fono Play Kids</strong> bajo la orden N°#' . $id . '.</p>
                <p>Para continuar con el proceso y asegurarte una atención oportuna y de calidad, por favor sigue los siguientes pasos:</p>
                <ol>
                    <li>Ingresa a la siguiente página: <a href="https://www.fonoplaykids.cl/valida_solicitud.php?id=' . $id_encript . '">https://www.fonoplaykids.cl/valida_solicitud/</a></li>
                    <li>Llena el formulario con los datos solicitados.</li>
                </ol>
                <p>Esto garantiza que tengas un cupo con nosotros. Una vez llenado y enviado el formulario, validaremos tus datos y te generaremos un cupo en nuestra lista de espera.</p>
                <p>Nos comunicaremos contigo a la brevedad posible.</p>
                <br>
                <p>Atentamente,</p>
                <p><strong>Equipo Fono Play Kids</strong></p>
                </body>
                </html>';

            $mail = new PHPMailer();
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'sistemas@saludohiggins.cl';
                $mail->Password = 'zqucioripnjvuqkd';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('sistemas@saludohiggins.cl', 'Fono Play Kids');
                $mail->addAddress($email, 'Cliente');

                $mail->isHTML(true);
                $mail->Subject = 'FonoPlayKids - Asegura un cupo con nosotros!!';
                $mail->Body = $mensaje;
                

                if ($mail->send()) {

                        $sql = "UPDATE solicitudes set correo=1 WHERE id={$id}";

                        $result = $conn->query($sql);

                        if ($result) {
                            echo json_encode(['codigo' => 0, 'mensaje' => 'Correo Enviado Correctamente']);
                            exit();
                        } else {
                            echo json_encode(['codigo' => 2, 'mensaje' => 'Error al enviar el correo', 'error' => $conn->error]);
                            exit();
                        }
                   
                } else {
                    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al enviar el correo', 'error' => $conn->error]);
                    exit();
                }
            } catch (Exception $e) {
                    echo json_encode(['codigo' => 2, 'mensaje' => 'Error al enviar el correo', 'error' => $conn->error]);
                    exit();
            }
        }



