<?php
// Conexión a la base de datos
$cnx = mysqli_connect("localhost", "root", "", "modelo");
if (!$cnx) die("Error de conexión: " . mysqli_connect_error());

// Procesar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = mysqli_real_escape_string($cnx, $_POST['id']);
    $nombre = mysqli_real_escape_string($cnx, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($cnx, $_POST['descripcion']);
    $nivel = mysqli_real_escape_string($cnx, $_POST['nivel']);
    
    // Actualizar el registro
    $sql = "UPDATE capacidad SET 
            Nombre = '$nombre',
            Descripcion = '$descripcion',
            Nivel = '$nivel'
            WHERE Id = '$id'";
    
    if (mysqli_query($cnx, $sql)) {
        header("Location: IndexC.php?success=1");
        exit;
    } else {
        $error = "Error al actualizar: " . mysqli_error($cnx);
    }
}

// Obtener datos del registro a editar
if (!isset($_GET['id'])) {
    die("Error: No se especificó el ID del registro");
}

$id = mysqli_real_escape_string($cnx, $_GET['id']);
$sql = "SELECT * FROM capacidad WHERE Id = '$id'";
$result = mysqli_query($cnx, $sql);

if (!$result || mysqli_num_rows($result) === 0) {
    die("Error: Registro no encontrado");
}

$registro = mysqli_fetch_assoc($result);
mysqli_close($cnx);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Capacidad</title>
    <link rel="stylesheet" href="stilesedi.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="form-container">
        <h1>Editar Datos</h1>
        
        <?php if (isset($error)): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="sp_editarC.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $registro['Id']; ?>">
            
            <div class="form-group">
                <label for="nombre">Concepto:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($registro['Nombre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required><?php echo htmlspecialchars($registro['Descripcion']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="nivel">Nivel:</label>
                <select id="nivel" name="nivel" required>
                    <option value="1" <?php echo ($registro['Nivel'] == 1) ? 'selected' : ''; ?>>Nivel 1</option>
                    <option value="2" <?php echo ($registro['Nivel'] == 2) ? 'selected' : ''; ?>>Nivel 2</option>
                    <option value="3" <?php echo ($registro['Nivel'] == 3) ? 'selected' : ''; ?>>Nivel 3</option>
                </select>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="button primary">ACTUALIZAR</button>
                <a href="IndexC.php" class="button secondary">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>