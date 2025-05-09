<?php
// Configuración de conexión (debería estar en un archivo aparte)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'modelo');

// Iniciar sesión para poder usar variables de sesión en los mensajes
session_start();

// Verificar método de solicitud
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = 'Método no permitido';
    header("Location: indexC.php");
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
    header("Location: indexC.php");
    exit;
}

if (empty($nombre) || empty($descripcion)) {
    $_SESSION['error'] = 'Nombre y descripción son obligatorios';
    header("Location: indexC.php");
    exit;
}

try {
    // Conexión a la base de datos
    $cnx = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Verificar conexión
    if ($cnx->connect_error) {
        throw new Exception("Error de conexión a la base de datos");
    }

    // Preparar consulta con sentencias preparadas
    $stmt = $cnx->prepare("UPDATE capacidadniveluno SET 
                          codigo = ?, 
                          nombre = ?, 
                          descripcion = ?, 
                          tipo = ? 
                          WHERE id = ?");
    
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta SQL");
    }
    
    // Vincular parámetros
    $stmt->bind_param("ssssi", $codigo, $nombre, $descripcion, $tipo, $id);
    
    // Ejecutar consulta
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la actualización");
    }
    
    // Verificar si se actualizó algún registro
    if ($stmt->affected_rows === 0) {
        $_SESSION['warning'] = 'No se realizaron cambios. El registro puede no existir.';
    } else {
        $_SESSION['success'] = 'Registro actualizado correctamente';
    }
    
    // Redireccionar a la página principal
    header("Location: index1.php");
    exit;
    
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: indexC.php");
    exit;
} finally {
    // Cerrar conexiones si existen
    if (isset($stmt)) $stmt->close();
    if (isset($cnx)) $cnx->close();
}