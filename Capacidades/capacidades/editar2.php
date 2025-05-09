<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edi1.css">
    <title>Editar Capacidad Nivel 2</title>
</head>
<body>
<?php
    // Recuperar los datos de la capacidad a editar
    $id = $_GET['id'];
    $codigo = $_GET['codigo'] ?? '';
    $nombre = $_GET['nombre'] ?? '';
    $descripcion = $_GET['descripcion'] ?? '';
    $tipo = $_GET['tipo'] ?? 'A5B'; // Valor por defecto A5B según la imagen
?>
<div class="edit-container">
    <h2>Editar Capacidad Nivel 2</h2>
    <form action="sp_editar2.php" method="post">
        <!-- Campos ocultos -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        <input type="hidden" name="tipo" value="<?= htmlspecialchars($tipo) ?>">
        
        <div class="form-group">
            <label for="codigo">Código:</label>
            <select id="codigo" name="codigo" required>
                <?php for($i = 1; $i <= 3; $i++): ?>
                    <option value="C-<?= $i ?>" <?= $codigo == "C-$i" ? 'selected' : '' ?>>C-<?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required>
        </div>
        
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion" rows="4" required><?= htmlspecialchars($descripcion) ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Tipo (no editable):</label>
            <input type="text" value="<?= htmlspecialchars($tipo) ?>" readonly class="read-only-field">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-update">Actualizar</button>
            <a href="index2.php" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>