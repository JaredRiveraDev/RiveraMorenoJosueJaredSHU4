<?php
// Inicia la sesión de usuario
session_start();

// Finaliza la sesión
session_unset();
session_destroy();

// Redirige a la página de inicio de sesión
header('Location: login.php');
exit;
