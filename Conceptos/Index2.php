<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Estilos2.css">
    <title>Conceptos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div>
        <!-- Enlace "Volver" que lleva al inicio -->
        <a href="/Ejemplos/" class="button">Volver</a>
        <a href="nuevo.php" class="button">Nuevo</a>
    </div>

    <div>
        <table border="1">
            <tr>
                <td>Concepto</td>
                <td>Descripción</td>
                <td>Acciones</td>
            </tr>
            <?php
            $cnx = mysqli_connect("localhost", "root", "", "modelo");
            if (!$cnx) {
                die("Error de conexión: " . mysqli_connect_error());
            }
            $sql = "SELECT id, Concepto, Descripcion FROM conceptos ORDER BY Concepto";
            $rta = mysqli_query($cnx, $sql);
            if ($rta && mysqli_num_rows($rta) > 0) {
                while ($mostrar = mysqli_fetch_assoc($rta)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($mostrar['Concepto']); ?></td>
                        <td><?php echo htmlspecialchars($mostrar['Descripcion']); ?></td>
                        <td>
                            <a href="editar.php?id=<?php echo $mostrar['id']; ?>&Concepto=<?php echo urlencode($mostrar['Concepto']); ?>&Descripcion=<?php echo urlencode($mostrar['Descripcion']); ?>">Editar</a>
                            <a href="sp_eliminar.php?id=<?php echo $mostrar['id']; ?>">Eliminar</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='3'>No hay datos disponibles</td></tr>";
            }

            mysqli_close($cnx);
            ?>
        </table>
    </div>
</body>
</html>
