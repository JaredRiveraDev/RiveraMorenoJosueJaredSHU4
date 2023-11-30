<?php
// Conexión a la base de datos
require("conn.php");

//incluimos las librerias
include 'cdn-links.html';

// Si se envió el formulario para actualizar el producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtenemos los datos del formulario
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    // Actualizamos el producto en la base de datos
    $sql = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', cantidad_disponible='$stock' WHERE id_producto=$id";
    $resultado = $conn->query($sql);

    // Si se actualizó correctamente, redirigimos a la página de listar productos
    if ($resultado) {
        echo '<script>
        iziToast.success({
            title: "¡Producto modificado!",
            message: "El producto se ha modificado correctamente.",
            position: "topRight",
        });
        
        // Redirigimos al usuario a la página anterior
        setTimeout(function() {
            window.location.href = "admin.php";
        }, 2000);
      </script>';
        exit();
    }
}

// Si se recibió el parámetro "id" en la URL, obtenemos los datos del producto de la base de datos
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id_producto=$id";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        $nombre = $fila['nombre'];
        $descripcion = $fila['descripcion'];
        $precio = $fila['precio'];
        $stock = $fila['cantidad_disponible'];
    } else {
        header('Location: admin.php');
        exit();
    }
} else {
    header('Location: admin.php');
    exit();
}

// Cerramos la conexión a la base de datos
$conn->close();
?>

<!-- Mostramos el formulario para editar el producto -->
<div class="container">
    <br>
    <h2>Editar producto</h2>
    <div class="col-6">
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nombre; ?>">
            <br><br>
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" class="form-control" id="descripcion"><?php echo $descripcion; ?></textarea>
            <br><br>
            <label for="precio">Precio:</label>
            <input type="number" class="form-control" name="precio" id="precio" value="<?php echo $precio; ?>">
            <br><br>
            <label for="stock">Stock:</label>
            <input type="number" class="form-control" name="stock" id="stock" value="<?php echo $stock; ?>">
            <br><br>
            <input type="submit" class="btn btn-success" value="Guardar cambios">
            <a href="admin.php" class="btn btn-danger">Cancelar</a>
        </form>
    </div>
</div>