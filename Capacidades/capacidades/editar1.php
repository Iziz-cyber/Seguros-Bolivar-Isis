<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edi1.css">
    <title>Editar Capacidad</title>
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
    <h2>Editar Capacidad</h2>
    <form action="sp_editar1.php" method="post">
        <!-- Campo oculto para el ID -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
        
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
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="A5E" <?= $tipo == 'A5E' ? 'selected' : '' ?>>A5E</option>
                <option value="DCM" <?= $tipo == 'DCM' ? 'selected' : '' ?>>DCM</option>
                <option value="SER" <?= $tipo == 'SER' ? 'selected' : '' ?>>SER</option>
                <option value="HOM" <?= $tipo == 'HOM' ? 'selected' : '' ?>>HOM</option>
                <option value="A5B" <?= $tipo == 'A5B' ? 'selected' : '' ?>>A5B</option>
                <option value="HLT" <?= $tipo == 'HLT' ? 'selected' : '' ?>>HLT</option>
                <option value="IPS" <?= $tipo == 'IPS' ? 'selected' : '' ?>>IPS</option>
                <option value="SSB" <?= $tipo == 'SSB' ? 'selected' : '' ?>>SSB</option>
                <option value="EL" <?= $tipo == 'EL' ? 'selected' : '' ?>>EL</option>
                <option value="CON" <?= $tipo == 'CON' ? 'selected' : '' ?>>CON</option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn-update">Actualizar</button>
            <a href="index1.php" class="btn-cancel">Cancelar</a>
        </div>
    </form>
</div>
</body>
</html>