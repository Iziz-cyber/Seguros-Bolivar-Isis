<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="insertC.css">
    <title>Nueva Capacidad</title>
</head>
<body>
<div>
    <form action="sp_insertarC.php" method="post">
        <table border="1">
            <tr>
                <td colspan="2" class="table-header">Ingresar nueva capacidad</td>
            </tr>
            <tr>
                <td>Nombre:</td>
                <td><input type="text" name="Nombre" required></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><textarea name="Descripcion" rows="4" required></textarea></td>
            </tr>
            <tr>
                <td colspan="2" class="action-buttons">
                    <input type="submit" value="Guardar" class="btn-save">
                    <a href="indexC.php" class="btn-cancel">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>