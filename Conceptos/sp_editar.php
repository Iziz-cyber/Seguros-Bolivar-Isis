<?php
    $id = $_POST['id'];
    $Concepto = $_POST['Concepto'];
    $Descripcion = $_POST['Descripcion'];

    // Conexión a la base de datos
    $cnx = mysqli_connect("localhost", "root", "", "modelo");

    // Verificar conexión
    if (!$cnx) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta SQL corregida con el nombre de la tabla
    $sql = "UPDATE conceptos set Concepto= '$Concepto', Descripcion= '$Descripcion' where id like $id";
    $rta = mysqli_query($cnx, $sql);

    // Validar el resultado de la inserción
    if ($rta) {
        // Redirigir a index.php si se inserta correctamente
        header("Location: index2.php");
        exit;
    } else {
        echo "No se Actualizo:" . mysqli_error($cnx);
    }

    // Cerrar conexión
    mysqli_close($cnx);
?>
