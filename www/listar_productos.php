<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado->num_rows > 0) {
                    while ($fila = $resultado->fetch_assoc()) {
                        $id = $fila['id'];
                        $nombre = $fila['nombre'];
                        $descripcion = $fila['descripcion'];
                        $precio = $fila['precio'];
                        $stock = $fila['stock'];
                        echo "<tr>";
                        echo "<td>$id</td>";
                        echo "<td>$nombre</td>";
                        echo "<td>$descripcion</td>";
                        echo "<td>$precio</td>";
                        echo "<td>$stock</td>";
                        echo "<td>";
                        echo "<a href='editar_producto.php?id=$id'>Editar</a>";
                        echo "<a href='eliminar_producto.php?id=$id'>Eliminar</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No se encontraron productos.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>
<?php
// Conexión a la base de datos
require("conn.php");

//incluimos las librerias
include 'cdn-links.html';

// Consulta para obtener todos los productos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

// Si hay productos, los mostramos en la tabla
if ($resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $fila['id'] . '</td>';
        echo '<td>' . $fila['nombre'] . '</td>';
        echo '<td>' . $fila['descripcion'] . '</td>';
        echo '<td>' . $fila['precio'] . '</td>';
        echo '<td>' . $fila['stock'] . '</td>';
        echo '<td>';
        echo '<a href="editar_producto.php?id=' . $fila['id'] . '">Editar</a>';
        echo '<a href="eliminar_producto.php?id=' . $fila['id'] . '">Eliminar</a>';
        echo '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="6">No hay productos</td></tr>';
}

// Cerramos la conexión a la base de datos
$conn->close();
