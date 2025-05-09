<?php
session_start(); // Debe ir al principio del archivo, antes de cualquier salida HTML

// Verificar si se ha solicitado cambiar el orden
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';
$next_order = $order === 'asc' ? 'desc' : 'asc';
$order_text = $order === 'asc' ? 'Orden: A-Z' : 'Orden: Z-A';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Capacidades</title>
    <link rel="stylesheet" href="StylesC.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Mostrar mensajes de éxito/error -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-message"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-message"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <div class="action-bar">
        <a href="/Inicio/" class="button">Volver</a>
        <a href="/Capacidades/insertarC.php" class="button">Nuevo</a>
        <a href="?order=<?php echo $next_order; ?>" id="toggleOrder" class="order-btn"><?php echo $order_text; ?></a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nivel</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $cnx = mysqli_connect("localhost", "root", "", "modelo");
            if (!$cnx) die("Error de conexión: " . mysqli_connect_error());

            // Modificar la consulta SQL según el orden seleccionado
            $sql = "SELECT Id, Codigo, Nivel, Nombre, Descripcion FROM capacidad ";
            $sql .= $order === 'asc' ? "ORDER BY Codigo ASC" : "ORDER BY Codigo DESC";
            
            $result = mysqli_query($cnx, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Codigo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nivel']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars(substr($row['Descripcion'], 0, 50)) . "...</td>";
                    echo "<td class='actions'>";
                    echo "<a href='editarC.php?id=" . $row['Id'] . "' class='edit-btn'>Editar</a>";
                    echo "<a href='eliminarC.php?id=" . $row['Id'] . "' class='delete-btn' onclick='return confirm(\"¿Eliminar registro?\");'>Borrar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='no-data'>No hay registros en la tabla.</td></tr>";
            }
            mysqli_close($cnx);
            ?>
        </tbody>
    </table>
</body>
</html>