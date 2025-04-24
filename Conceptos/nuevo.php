<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nuevo.css">
    <title>Nuevos Datos</title>
</head>
<body>
<div>
    <form action="sp_insertar.php" method="post">
        <table border="1">
            <tr>
                <td colspan="2" class="table-header">Ingresar dato nuevo</td>
            </tr>
            <tr>
                <td>Concepto:</td>
                <td><input type="text" name="Concepto" id="" required></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><input type="text" name="Descripcion" id="" required></td>
            </tr>
            <tr>
                <td colspan="2" class="action-buttons">
                    <input type="submit" value="Guardar" class="btn-save">
                    <a href="index2.php" class="btn-cancel">Cancelar</a>
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
