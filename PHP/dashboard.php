<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

// Incluir el archivo de conexión a la base de datos
require 'conexion.php';

// Obtener los datos del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Mejorar la seguridad de la consulta y obtener todos los datos del usuario
$sql = "SELECT id, nombre_completo, correo, fecha_creacion FROM usuarios WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    session_destroy();
    header("Location: ../login.html");
    exit;
}

$user = $result->fetch_assoc();

// Formatear la fecha de creación
$fecha_formateada = date('d/m/Y', strtotime($user['fecha_creacion']));

// Cerrar la consulta
$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Red Metro</title>
    <link rel="stylesheet" href="../CSS/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="dashboard-container">
        <div class="user-profile">
            <div class="profile-header">
                <h1>Bienvenido a tu cuenta</h1>
                <h2><?php echo htmlspecialchars($user['nombre_completo']); ?></h2>
            </div>

            <div class="user-info">
                <div class="info-card">
                    <span class="info-label">Eres nuestro usuario: <?php echo htmlspecialchars($user['id']); ?></span>
                    <p>#<?php echo htmlspecialchars($user['id']); ?></p>
                </div>

                <div class="info-card">
                    <span class="info-label">Correo Electrónico</span>
                    <p><?php echo htmlspecialchars($user['correo']); ?></p>
                </div>

                <div class="info-card">
                    <span class="info-label">Fecha de Registro</span>
                    <p><?php echo htmlspecialchars($fecha_formateada); ?></p>
                </div>
            </div>

            <div class="user-actions">
                <a href="editar_perfil.php" class="action-btn edit-btn">Editar Perfil</a>
                <a href="cambiar_contrasena.php" class="action-btn password-btn">Cambiar Contraseña</a>
                <a href="logout.php" class="action-btn logout-btn">Cerrar Sesión</a>
            </div>
        </div>
    </div>

    <script>
        // Agregar animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('.dashboard-container').classList.add('loaded');
        });
    </script>
</body>
</html>