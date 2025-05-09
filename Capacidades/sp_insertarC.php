<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "modelo";  // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Recoger datos del formulario
$nombre = $_POST['Nombre'];
$descripcion = $_POST['Descripcion'];

// Insertar en la tabla capacidad
$sql = "INSERT INTO capacidad (nombre, descripcion) VALUES (?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $nombre, $descripcion);

if ($stmt->execute()) {
    echo "Datos insertados correctamente en la tabla capacidad.";
} else {
    echo "Error al insertar datos: " . $conn->error;
}

$stmt->close();
$conn->close();

// Redireccionar después de 2 segundos
header("refresh:2; url=index2.php");
?>