<?php
session_start();
require_once('../config/database.php');
$usuario = $_SESSION['id_usuario'];

$conn = new mysqli($servername, $username, $password, $dbname,$port);

$sql = "SELECT fecha from fecha_lista";

$result = $conn->query($sql);

// print_r($result);
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo $row['fecha'];
    }
}