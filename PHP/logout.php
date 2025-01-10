<?php
// Iniciar la sesión
session_start();

// Destruir todas las sesiones
session_destroy();

// Redirigir al usuario al inicio de sesión
header("Location:../login.html");
exit;
?>
