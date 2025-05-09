<?php
// Configuración de conexión
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'modelo');

session_start();

// Verificar método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Método no permitido';
    header("Location: index2.php"); // Cambiado a index2.php
    exit;
}

// Validar y sanitizar datos de entrada
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$codigo = trim($_POST['codigo'] ?? '');
$nombre = trim($_POST['nombre'] ?? '');
$descripcion = trim($_POST['descripcion'] ?? '');
$tipo = trim($_POST['tipo'] ?? '');

// Validaciones básicas
if (!$id || $id <= 0) {
    $_SESSION['error'] = 'ID inválido';
    header("Location: index2.php"); // Cambiado a index2.php
    exit;
}

if (empty($nombre) || empty($descripcion)) {
    $_SESSION['error'] = 'Nombre y descripción son obligatorios';
    header("Location: index2.php"); // Cambiado a index2.php
    exit;
}

try {
    $cnx = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($cnx->connect_error) {
        throw new Exception("Error de conexión a la base de datos");
    }

    $stmt = $cnx->prepare("UPDATE capacidadniveldos SET 
                         codigo = ?, 
                         nombre = ?, 
                         descripcion = ?,
                         tipo = ?
                         WHERE id = ?");
    
    $stmt->bind_param("ssssi", $codigo, $nombre, $descripcion, $tipo, $id);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la actualización");
    }
    
    $_SESSION['success'] = 'Capacidad nivel 2 actualizada correctamente';
    header("Location: /Capacidades/capacidades/Index.2.php"); // Cambiado a index2.php
    exit;
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: /Capacidades/capacidades/Index.2.php"); // Cambiado a index2.php
    exit;
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($cnx)) $cnx->close();
}