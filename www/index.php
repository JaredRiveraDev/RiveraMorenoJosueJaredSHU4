<?php
// Inicia la sesión de usuario
session_start();
?>

<?php
// Conexión a la base de datos
require("conn.php");
// Estilo de la pagina modificable desde admin.php
include 'config.php';
// Obtenemos la lista de productos de la base de datos
$sql = "SELECT * FROM productos";
$resultado = $conn->query($sql);

// Cerramos la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="assets/img/minilogo.png" />
  <!-- cdn bostrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="assets/css/style.css" />
  <title>Cuidado Con El Toro</title>
  <style>
    body {
      background-color: <?php echo $color_principal; ?>;
    }
  </style>
</head>

<body>
  <!-- EN: navbar
    ES: barra de navegación -->
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <b><a class="navbar-brand" href="#">
          <img src="assets/img/minilogo.png" alt="" width="30" height="24" class="d-inline-block align-text-top" />
          <?php echo $h1; ?>
        </a></b>
      <form class="d-flex">
        <ul class="navbar-nav mr-auto">


        </ul>

        <!-- Enlace al formulario de inicio de sesión -->
        <a href="login.php" <?php if (isset($_SESSION['user_role'])) { ?>style="display:none" <?php } ?> class="mx-2">
          <img src="assets/img/user.png" alt="user" width="30" height="24" />
        </a>

        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') { ?>
          <!-- Botón para realizar acciones de administrador -->
          <a href="admin.php" class="btn btn-success mx-2">Panel de Administrador</a>
        <?php } ?>

        <?php
        // Verifica si la variable de sesión "user_role" existe
        if (isset($_SESSION['user_role'])) {
          // Muestra el botón de cerrar sesión en lugar del icono de usuario
          echo '<a href="logout.php" class="btn btn-danger ms-auto mx-2">Cerrar sesión</a>';
        }
        ?>

      </form>
    </div>
  </nav>
  <br />
  <!-- //EN: products
    //ES: productos -->
  <center>
    <h2>Productos</h2>
  </center>
  <div class="container">
    <!-- <div class="alert alert-success">
      pantalla de mensaje...
      <a href="#" class="badge bg-success">Ver carrito</a>
    </div> -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php
      while ($row = mysqli_fetch_assoc($resultado)) {
        echo "<div class='col'>
          <div class='card h-100'>
            <img src='{$row['imagen']}' class='card-img-top' alt='{$row['nombre']}'>
            <div class='card-body'>
              <h5 class='card-title'>{$row['nombre']}</h5>
              <p class='card-text'>{$row['descripcion']}</p>
              <p class='precio'>$ " . number_format($row['precio'], 0, '.', ',') . "</p>
              <form method='post'>
          <input type='hidden' name='product_id' value='{$row['id_producto']}'>
          <input type='hidden' name='product_name' value='{$row['nombre']}'>
          <input type='hidden' name='product_price' value='{$row['precio']}'>
          
          
          </form>
            </div>
          </div>
        </div>";
      }
      ?>
    </div>
    <br><br>
  </div>
</body>

</html>

<style>
  .precio {
    position: absolute;
    bottom: 0;
    right: 0;
    background-color: #000;
    color: #fff;
    padding: 5px;
    transition: background-color 0.5s ease;
  }

  .precio:hover {
    background-color: #fff;
    color: #000;
  }

  .card {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    transition: transform 0.3s;
  }

  .card:hover {
    transform: translateY(-10px);
  }

  .card-img-top {
    height: 300px;
    object-fit: cover;
  }

  .card-title {
    font-size: 1.2rem;
    font-weight: bold;
  }

  .card-text {
    font-size: 1rem;
  }

  .btn-comprar {
    background-color: #007bff;
    color: #fff;
    border: none;
  }
</style>