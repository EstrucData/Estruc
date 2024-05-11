<?php
header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['firstName'], $data['lastName'], $data['newUsername'], $data['newPassword'], $data['selectedCareer'])) {
    echo json_encode(['error' => 'Faltan datos en la solicitud']);
    exit;
}

$servername = "localhost";
$username = "tadeo";
$password = "Qwerty12345&";
$dbname = "estructuras";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$usuario = mysqli_real_escape_string($conn, $data['newUsername']);
$contrasena = hash('sha256', mysqli_real_escape_string($conn, $data['newPassword']));
$firstName = mysqli_real_escape_string($conn, $data['firstName']);
$lastName = mysqli_real_escape_string($conn, $data['lastName']);
$selectedCareer = intval($data['selectedCareer']);

$query = "INSERT INTO alumnos (nombres, apellidos, usuario, contraseña, id_carrera) 
          VALUES ('$firstName', '$lastName', '$usuario', '$contrasena', $selectedCareer)";

if ($conn->query($query) === TRUE) {
    echo json_encode(['nombre' => $data['newUsername']]);
} else {
    echo json_encode(['error' => 'Error al registrar usuario en la base de datos']);
}

$conn->close();
?>
