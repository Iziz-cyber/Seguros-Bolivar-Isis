<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="editar.css">
    <title>Editar</title>
</head>
<body>
<?php
    $id = $_GET['id'];
    $Concepto = $_GET['Concepto'];
    $Descripcion = $_GET['Descripcion'];
?>
<div>
    <form action="sp_editar.php" method="post">
        <table border="1">
            <tr>
                <td colspan="2">Editar Datos</td>
                <td><input type="text" name="id" id="" style="visibility:hidden" value="<?=$id?>"></td>
            </tr>
            <tr>
                <td>Concepto:</td>
                <td><input type="text" name="Concepto" id="" value="<?=$Concepto?>"></td>
            </tr>
            <tr>
                <td>Descripción:</td>
                <td><input type="text" name="Descripcion" id="" value="<?=$Descripcion?>"></td>
            </tr>
            <tr>
                <td colspan="2"><input type="submit" value="Actualizar"></td>
                <td><a href="index2.php">Cancelar</a></td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
