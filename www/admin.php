<?php
// Inicia la sesión de usuario
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/img/minilogo.png" />
    <!-- cdn toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- cdn bostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Administrador</title>
</head>

<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <b><a class="navbar-brand" href="#">
                    <img src="assets/img/minilogo.png" alt="" width="30" height="24" class="d-inline-block align-text-top" />
                    Cuidado Con El Toro
                </a></b>

            <form class="d-flex">
                <a href="index.php" class="btn btn-dark ms-auto mx-2">Ver página</a>
                <a href="logout.php" class="btn btn-danger ms-auto mx-2">Cerrar sesión</a>
            </form>
        </div>
    </nav>

    <div class="container">
        <center>
            <h1>Administrador de la tienda</h1>
        </center>
        <div class="row">
            <!-- subir productos -->
            <div class="col-sm-6">
                <h2>Subir nuevos productos</h2>
                <form action="procesar_producto.php" method="post" enctype="multipart/form-data">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required><br><br>

                    <label for="descripcion">Descripción:</label><br>
                    <textarea id="descripcion" class="form-control" name="descripcion" rows="5" cols="30" required></textarea><br><br>

                    <label for="precio">Precio:</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="precio" name="precio" step="0.01" min="0" required>
                        <span class="input-group-text">.mx</span>
                    </div><br><br>

                    <label for="stock">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" min="0" required><br><br>

                    <label for="imagen">Imagen:</label>
                    <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required><br><br>

                    <input type="submit" value="Subir producto" class="btn btn-success">
                </form>
            </div>

            <?php
            //cambiar la apariencia de la app
            include 'config.php';

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $logo = $_POST['logo'];
                $h1 = $_POST['h1'];
                $color_principal = $_POST['color_principal'];

                // Ruta donde se guardan las imágenes
                $upload_dir = 'assets/config/';

                file_put_contents('config.php', "<?php\n\$logo = \"$logo\";\n\$h1 = \"$h1\";\n\$color_principal = \"$color_principal\";\n?>");

                // Si se ha enviado un archivo
                if (isset($_FILES['logo'])) {
                    // Obtener información del archivo
                    $file_name = $_FILES['logo']['name'];
                    $file_tmp = $_FILES['logo']['tmp_name'];
                    $file_type = $_FILES['logo']['type'];
                    $file_size = $_FILES['logo']['size'];

                    // Eliminar la imagen anterior (si existe)
                    $old_logo = 'assets/config/logo.png';
                    if (file_exists($old_logo)) {
                        unlink($old_logo);
                    }

                    // Mover la imagen cargada a la carpeta de destino
                    move_uploaded_file($file_tmp, $upload_dir . $file_name);
                }
                echo '<script>
                iziToast.success({
                    title: "¡Cambios Guardados!",
                    message: "La Apariencia de la web se ha modificado correctamente.",
                    position: "topRight",
                });
              </script>';
            }
            ?>

            <div class="col-sm-6">
                <h2>Administrar apariencia</h2>
                <form method="post">
                    <label for="logo">Logo:</label>
                    <input type="file" name="logo" class="form-control" id="logo">

                    <label for="h1">H1 principal:</label>
                    <input type="text" class="form-control" id="h1" name="h1" value="<?php echo $h1; ?>"><br>

                    <label for="color_principal">Color principal:</label>
                    <input type="color" class="form-control form-control-color" id="color_principal" name="color_principal" value="<?php echo $color_principal; ?>"><br>

                    <input type="submit" value="Guardar cambios" class="btn btn-success">
                </form>
            </div>
        </div>
        <br>

        <!-- Tabla de productos -->
        <?php
        // Conexión a la base de datos
        require("conn.php");

        // Obtenemos la lista de productos de la base de datos
        $sql = "SELECT * FROM productos";
        $resultado = $conn->query($sql);

        // Cerramos la conexión a la base de datos
        $conn->close();
        ?>

        <!-- Mostramos la tabla con la lista de productos -->
        <div class="listar-productos">
            <h2>Lista de productos</h2>
            <input type="text" class="form-control" id="filtro" placeholder="Buscar producto...">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php


                    // Recorremos los resultados y mostramos los productos en la tabla
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>{$row['id_producto']}</td>";
                        echo "<td>{$row['nombre']}</td>";
                        echo "<td>{$row['descripcion']}</td>";
                        echo "<td><img src='{$row['imagen']}' width='100'></td>";
                        echo "<td>$ {$row['precio']}</td>";
                        echo "<td>{$row['cantidad_disponible']}</td>";
                        echo "<td>";
                        echo "<a class='btn btn-primary' href='editar_producto.php?id={$row['id_producto']}'>Editar</a> ";
                        echo "<a class='btn btn-danger' href='eliminar_producto.php?id={$row['id_producto']}' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\")'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>


    </div>


</body>

</html>

<!-- filtro en tiempo real -->
<script>
    $(document).ready(function() {
        $("#filtro").on("keyup", function() {
            var valor = $(this).val().toLowerCase();
            $("tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(valor) > -1)
            });
        });
    });
</script>

<?php
// Verifica si el usuario tiene permisos de administrador
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    // Si el usuario no es administrador, muestra una alerta con iziToast
    echo "<script>iziToast.error({
        title: 'Acceso restringido',
        message: 'Solo administradores',
        position: 'center',
        timeout: 3000,
        progressBar: false,
        close: false,
        overlay: true,
        overlayClose: false,
        zindex: 9999
    });
    setTimeout(function() {
        window.location.href = 'index.php';
    }, 3000);
    </script>";
}
?>