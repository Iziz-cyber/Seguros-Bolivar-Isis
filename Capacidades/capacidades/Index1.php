<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capacidades Nivel 1</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="index1.css">
</head>
<body>
    <?php
    session_start();
    
    // Mostrar mensajes de éxito/error
    if (isset($_SESSION['error'])) {
        echo '<div class="alert error">'.htmlspecialchars($_SESSION['error']).'</div>';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<div class="alert success">'.htmlspecialchars($_SESSION['success']).'</div>';
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['warning'])) {
        echo '<div class="alert warning">'.htmlspecialchars($_SESSION['warning']).'</div>';
        unset($_SESSION['warning']);
    }
    ?>

    <div class="header">
        <h1>Capacidades Nivel 1</h1>
        <a href="/Capacidades/nuevoC.php" class="button">Volver</a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $cnx = mysqli_connect("localhost", "root", "", "modelo");
                if (!$cnx) {
                    die('<tr><td colspan="5" class="error">Error de conexión: '.htmlspecialchars(mysqli_connect_error()).'</td></tr>');
                }
                
                $sql = "SELECT Id, Codigo, Nombre, Descripcion, Tipo FROM capacidadniveluno ORDER BY Codigo";
                $rta = mysqli_query($cnx, $sql);
                
                if ($rta && mysqli_num_rows($rta) > 0) {
                    while ($mostrar = mysqli_fetch_assoc($rta)) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($mostrar['Codigo']); ?></td>
                            <td><?php echo htmlspecialchars($mostrar['Nombre']); ?></td>
                            <td><?php echo htmlspecialchars($mostrar['Descripcion']); ?></td>
                            <td><?php echo htmlspecialchars($mostrar['Tipo']); ?></td>
                            <td class="actions">
                                <a href="editar1.php?id=<?php echo $mostrar['Id']; ?>" class="btn-edit">Editar</a>
                                <a href="sp_eliminar1.php?id=<?php echo $mostrar['Id']; ?>" 
                                   class="btn-delete" 
                                   onclick="return confirm('¿Está seguro de eliminar esta capacidad?\n\nCódigo: <?php echo addslashes($mostrar['Codigo']); ?>\nNombre: <?php echo addslashes($mostrar['Nombre']); ?>')">
                                   Eliminar
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="5" class="no-data">No hay capacidades registradas</td></tr>';
                }
                
                mysqli_close($cnx);
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Confirmación de eliminación mejorada
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm(this.getAttribute('data-confirm') || '¿Está seguro de eliminar esta capacidad?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>