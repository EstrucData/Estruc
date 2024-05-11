<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Content-Type: application/json');

$servername = "localhost";
$username = "tadeo";
$password = "Qwerty12345&";
$database = "estructuras";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

$sql = "SELECT id_carrera, nombre FROM carreras";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $careers = array();

    while($row = $result->fetch_assoc()) {
        $career = array(
            'id_carrera' => $row['id_carrera'],
            'nombre' => $row['nombre']
        );
        $careers[] = $career;
    }

    echo json_encode($careers);
} else {
    echo json_encode(array());
}

$conn->close();
?>
