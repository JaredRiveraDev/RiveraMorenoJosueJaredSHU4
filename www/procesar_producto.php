<?php
// Conexión a la base de datos
require("conn.php");

//incluimos las librerias
include 'cdn-links.html';

// Recibimos los datos del formulario
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];

// Procesamos la imagen
$imagen = $_FILES['imagen']['name'];
$temp = $_FILES['imagen']['tmp_name'];
$ruta = "productos/" . $imagen;
move_uploaded_file($temp, $ruta);

// Insertamos el producto en la base de datos
$sql = "INSERT INTO Productos (nombre, descripcion, precio, cantidad_disponible, imagen)
        VALUES ('$nombre', '$descripcion', $precio, $stock, '$ruta')";
if ($conn->query($sql) === TRUE) {
    echo '<script>
        iziToast.success({
            title: "¡Producto subido!",
            message: "El producto se ha subido correctamente.",
            position: "topRight",
        });
        
        // Redirigimos al usuario a la página anterior
        setTimeout(function() {
            window.location.href = "admin.php";
        }, 3000);
      </script>';
} else {
    echo "Error al subir el producto: " . $conn->error;
}

// Cerramos la conexión
$conn->close();
