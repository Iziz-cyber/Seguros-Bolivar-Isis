<?php
// Iniciar sesión para manejar mensajes de error/success
session_start();

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Método no permitido";
    header("Location: IndexC.php");
    exit;
}

// Validar datos requeridos
$required_fields = ['id', 'Concepto', 'Descripcion', 'Nivel', 'Codigo'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        $_SESSION['error'] = "El campo $field es requerido";
        header("Location: IndexC.php");
        exit;
    }
}

// Conexión a la base de datos
$cnx = mysqli_connect("localhost", "root", "", "modelo");
if (!$cnx) {
    $_SESSION['error'] = "Error de conexión: " . mysqli_connect_error();
    header("Location: IndexC.php");
    exit;
}

// Escapar datos para prevenir inyección SQL
$id = mysqli_real_escape_string($cnx, $_POST['id']);
$Concepto = mysqli_real_escape_string($cnx, $_POST['Concepto']);
$Descripcion = mysqli_real_escape_string($cnx, $_POST['Descripcion']);
$Nivel = (int)$_POST['Nivel'];
$Codigo = mysqli_real_escape_string($cnx, $_POST['Codigo']);

// Iniciar transacción para asegurar integridad de datos
mysqli_begin_transaction($cnx);

try {
    // Determinar tabla actual
    $tabla_actual = "";
    $sql_detectar_tabla = "SELECT 'capacidadniveluno' AS tabla FROM capacidadniveluno WHERE Id = '$id'
                           UNION SELECT 'capacidadniveldos' AS tabla FROM capacidadniveldos WHERE Id = '$id'
                           UNION SELECT 'capacidadniveltres' AS tabla FROM capacidadniveltres WHERE Id = '$id'";
    $resultado = mysqli_query($cnx, $sql_detectar_tabla);
    
    if (!$resultado || mysqli_num_rows($resultado) === 0) {
        throw new Exception("No se encontró el registro en ninguna tabla");
    }
    
    $fila = mysqli_fetch_assoc($resultado);
    $tabla_actual = $fila['tabla'];

    // Validar nivel
    $tablas_niveles = [
        1 => 'capacidadniveluno',
        2 => 'capacidadniveldos',
        3 => 'capacidadniveltres'
    ];
    
    if (!array_key_exists($Nivel, $tablas_niveles)) {
        throw new Exception("Nivel no válido");
    }
    
    $tabla_destino = $tablas_niveles[$Nivel];
    $nuevo_codigo = generarNuevoCodigo($Nivel, $Codigo);

    // Si cambió de nivel (y tabla)
    if ($tabla_actual != $tabla_destino) {
        // 1. Obtener datos del registro actual
        $sql_select = "SELECT * FROM $tabla_actual WHERE Id = '$id'";
        $resultado = mysqli_query($cnx, $sql_select);
        
        if (!$resultado || mysqli_num_rows($resultado) === 0) {
            throw new Exception("Error al obtener registro actual");
        }
        
        $registro = mysqli_fetch_assoc($resultado);
        
        // 2. Insertar en nueva tabla
        $columnas = array_map(function($col) use ($cnx) {
            return mysqli_real_escape_string($cnx, $col);
        }, array_keys($registro));
        
        $valores = array_map(function($val) use ($cnx) {
            return "'" . mysqli_real_escape_string($cnx, $val) . "'";
        }, array_values($registro));
        
        // Actualizar campos modificados
        $registro['Codigo'] = $nuevo_codigo;
        $registro['Nombre'] = $Concepto;
        $registro['Descripcion'] = $Descripcion;
        
        $sql_insert = "INSERT INTO $tabla_destino (" . implode(", ", $columnas) . ") 
                       VALUES (" . implode(", ", $valores) . ")";
        
        if (!mysqli_query($cnx, $sql_insert)) {
            throw new Exception("Error al mover el registro: " . mysqli_error($cnx));
        }
        
        // 3. Eliminar de tabla original
        $sql_delete = "DELETE FROM $tabla_actual WHERE Id = '$id'";
        if (!mysqli_query($cnx, $sql_delete)) {
            throw new Exception("Error al eliminar registro original: " . mysqli_error($cnx));
        }
    } else {
        // Actualizar en la misma tabla
        $sql_update = "UPDATE $tabla_actual SET 
                       Nombre = '$Concepto', 
                       Descripcion = '$Descripcion', 
                       Codigo = '$nuevo_codigo' 
                       WHERE Id = '$id'";
        
        if (!mysqli_query($cnx, $sql_update)) {
            throw new Exception("Error al actualizar: " . mysqli_error($cnx));
        }
    }
    
    // Confirmar transacción
    mysqli_commit($cnx);
    $_SESSION['success'] = "Registro actualizado correctamente";
    header("Location: IndexC.php");
    exit;

} catch (Exception $e) {
    // Revertir transacción en caso de error
    mysqli_rollback($cnx);
    $_SESSION['error'] = $e->getMessage();
    header("Location: IndexC.php");
    exit;
} finally {
    mysqli_close($cnx);
}

// Función mejorada para generar códigos
function generarNuevoCodigo($nivel, $codigo_actual) {
    // Validar código existente
    if (!preg_match('/^[A-Za-z0-9.-]+$/', $codigo_actual)) {
        throw new Exception("Formato de código inválido");
    }
    
    // Extraer sufijo si existe (parte después del punto)
    $sufijo = '';
    if (strpos($codigo_actual, '.') !== false) {
        $sufijo = substr($codigo_actual, strpos($codigo_actual, '.'));
    }
    
    // Generar nuevo código basado en nivel
    return "C-$nivel" . $sufijo;
}
