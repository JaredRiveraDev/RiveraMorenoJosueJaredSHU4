<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>carrito</title>
</head>

<body>
    <table class="table">
        </thead>
        <tbody>
            <?php
            // Inicia la sesión de usuario
            session_start();

            // Definir la variable $_SESSION["cart"]
            $_SESSION["carrito"] = array();
            // verificar si se ha enviado una solicitud para agregar un producto
            if (isset($_POST['action']) && $_POST['action'] == 'add') {
                // agregar el producto al carrito
                $product_id = $_POST['id_producto'];
                $product_name = $_POST['nombre'];
                $product_price = $_POST['precio'];
                // aquí agregarías el producto a una variable de sesión o a una base de datos
            }

            // obtener los productos del carrito
            if (isset($_SESSION['carrito'])) {
                $products = $_SESSION['carrito'];
            } else {
                $products = array();
            }

            // mostrar los productos en el carrito
            if (count($products) > 0) {
                echo "<table class='table'>
          <thead>
            <tr>
              <th>Producto</th>
              <th>Precio</th>
              <th>Cantidad</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>";
                foreach ($products as $product) {
                    echo "<tr>
            <td>{$product['name']}</td>
            <td>$" . number_format($product['price'], 2, '.', ',') . "</td>
            <td>{$product['quantity']}</td>
            <td>$" . number_format($product['price'] * $product['quantity'], 2, '.', ',') . "</td>
          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No hay productos en el carrito.</p>";
            }

            ?>

        </tbody>
    </table>
</body>

</html>