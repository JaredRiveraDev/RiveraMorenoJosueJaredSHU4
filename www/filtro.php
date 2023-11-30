<?php
// Conexión a la base de datos
require("conn.php");

// Obtener el término de búsqueda del parámetro "q" en la URL
$q = isset($_GET['q']) ? $_GET['q'] : '';


// Construir la consulta SQL
$sql = "SELECT * FROM productos";
if (!empty($q)) {
    $q = '%' . $q . '%'; // Agregar comodines para que la búsqueda sea más amplia
    $sql .= " WHERE nombre LIKE ? OR descripcion LIKE ?";
}

// Preparar la consulta SQL y ejecutarla
$stmt = mysqli_prepare($conn, $sql);
if (!empty($q)) {
    $parametro = "%$q%";
    mysqli_stmt_bind_param($stmt, "ss", $parametro, $parametro);
}
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$productos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

// Mostrar la tabla de productos
// ...
