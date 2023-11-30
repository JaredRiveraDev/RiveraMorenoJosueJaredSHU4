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
    <!-- cdn bostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="assets/css/login.css">
    <title>login</title>
</head>

<body class="aling">
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <b><a class="navbar-brand" href="index.php">
                    <img src="assets/img/minilogo.png" alt="" width="30" height="24" class="d-inline-block align-text-top" />
                    Cuidado Con El Toro
                </a></b>
        </div>
    </nav>
    <br>

    <div class="grid">

        <form action="login.php" method="post" class="form login">

            <header class="login__header">
                <h3 class="login__title">Login</h3>
            </header>

            <div class="login__body">

                <div class="form__field">
                    <input type="email" placeholder="Email" name="email" required>
                </div>

                <div class="form__field">
                    <input type="password" placeholder="Password" name="password" required>
                </div>

            </div>

            <footer class="login__footer">
                <input type="submit" value="Iniciar sesión">

                <p><span class="icon icon--info">?</span><a href="#">Forgot Password</a></p>
            </footer>

        </form>

    </div>

</body>

</html>

<?php
// Inicia la sesión de usuario
session_start();

// Conexión a la base de datos
require("conn.php");

// Verifica que el formulario se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos ingresados por el usuario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta la base de datos para verificar las credenciales
    $query = "SELECT * FROM users WHERE correo = '$email' AND password = '$password'";
    $result = $conn->query($query);


    // Si se encontró un registro, inicia la sesión y redirige según el rol
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        // Si la contraseña es incorrecta, muestra una alerta con "toastr"
        echo "<script>iziToast.error({
            title: 'Error',
            message: 'Contraseña incorrecta',
            position: 'topRight'
          });</script>";
    }
}
?>