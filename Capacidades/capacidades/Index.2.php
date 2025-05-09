<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index2.css">
    <title>Capacidades Nivel 2</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div>
        <a href="/Capacidades/nuevoC.php" class="button">Volver</a>
    </div>

    <div>
        <table>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Capacidad Nivel 1</th>
                <th class="acciones">Acciones</th>
            </tr>
            <?php
            $cnx = mysqli_connect("localhost", "root", "", "modelo");
            if (!$cnx) {
                die("Error de conexión: " . mysqli_connect_error());
            }

            $sql = "SELECT c2.Id, c2.Codigo, c2.Nombre, c2.Descripcion, c1.Nombre as NivelUno 
                   FROM capacidadniveldos c2
                   JOIN capacidadniveluno c1 ON c2.IdCapacidadNivelUno = c1.Id
                   ORDER BY c2.Codigo";
            $result = mysqli_query($cnx, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Codigo']); ?></td>
                        <td><?php echo htmlspecialchars($row['Nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['Descripcion']); ?></td>
                        <td><?php echo htmlspecialchars($row['NivelUno']); ?></td>
                        <td class="acciones">
                            <a href="editar2.php?id=<?php echo $row['Id']; ?>" class="button">Editar</a>
                            <a href="sp_eliminar2.php?id=<?php echo $row['Id']; ?>" class="button" onclick="return confirm('¿Eliminar esta capacidad?')">Eliminar</a>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                echo "<tr><td colspan='5'>No hay capacidades de nivel 2 registradas</td></tr>";
            }

            mysqli_close($cnx);
            ?>
        </table>
    </div>
</body>
</html>