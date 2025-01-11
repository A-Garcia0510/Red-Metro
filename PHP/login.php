<?php
// Incluir archivo de conexión a la base de datos
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        echo '<script>alert("Por favor, completa todos los campos.");</script>';
        echo '<script>window.location.href = "../login.html";</script>';
    } else {
        // Consulta para verificar si el usuario existe
        $sql = "SELECT id, nombre_completo, contrasena FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verificar si la contraseña es correcta
            if (password_verify($password, $user['contrasena'])) {
                // Iniciar sesión
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nombre_completo'];

                // Redirigir al usuario a la página principal (o al dashboard)
                echo '<script>window.location.href = "dashboard.php";</script>';
                echo '<script>alert("Inicio de sesión exitoso.");</script>';
            } else {
                echo '<script>alert("La contraseña es incorrecta.");</script>';
                echo '<script>window.location.href = "../login.html";</script>';
            }
        } else {
            echo '<script>alert("No se encontró una cuenta con este correo.");</script>';
            echo '<script>window.location.href = "../login.html";</script>';
        }

        $stmt->close();
    }
} else {
    echo '<script>alert("Método no permitido.");</script>';
    echo '<script>window.location.href = "../login.html";</script>';
}
?>

