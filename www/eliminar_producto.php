<?php
// Conexión a la base de datos
require("conn.php");

//incluimos las librerias
include 'cdn-links.html';

// Si se recibió el parámetro "id" en la URL, eliminamos el producto de la base de datos
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM productos WHERE id_producto=$id";
    $resultado = $conn->query($sql);
}

// Cerramos la conexión a la base de datos
$conn->close();

// Redirigimos a la página de listar productos
header('Location: admin.php');
exit();
