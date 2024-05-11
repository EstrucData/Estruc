<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$servername = "localhost";
$username = "tadeo";
$password = "Qwerty12345&";
$dbname = "estructuras";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario = mysqli_real_escape_string($conn, $data['username']);
$contrasena = hash('sha256', mysqli_real_escape_string($conn, $data['password']));

$query = "SELECT usuario, nombres, apellidos, id_carrera FROM alumnos WHERE usuario = '$usuario' AND contraseña = '$contrasena'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $nombreCompleto = $fila['nombres'] . ' ' . $fila['apellidos'];
    echo json_encode([
        'authenticated' => true,
        'username' => $fila['usuario'],
        'fullName' => $nombreCompleto,
        'career' => $fila['id_carrera']
    ]);
} else {
    echo json_encode(['authenticated' => false]);
}

$conn->close();
?>