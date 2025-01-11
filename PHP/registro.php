<?php
// Incluir archivo de conexión a la base de datos
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm-password']);

    // Validar que no haya campos vacíos
    if (empty($nombre) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo '<script>alert("Por favor, completa todos los campos.");</script>';
        echo '<script>window.location.href = "../registro.html";</script>';
    } else {
        // Validar que las contraseñas coincidan
        if ($password !== $confirmPassword) {
            echo '<script>alert("Las contraseñas no coinciden.");</script>';
            echo '<script>window.location.href = "../registro.html";</script>';
        } else {
            // Cifrar la contraseña
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);

            // Verificar si el correo ya existe
            $sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bind_param("s", $email);
            $stmtCheck->execute();
            $resultCheck = $stmtCheck->get_result();

            if ($resultCheck->num_rows > 0) {
                echo '<script>alert("El correo ya está registrado.");</script>';
                echo '<script>window.location.href = "../registro.html";</script>';
            } else {
                // Insertar el nuevo usuario en la base de datos
                $sqlInsert = "INSERT INTO usuarios (nombre_completo, correo, contrasena) VALUES (?, ?, ?)";
                $stmtInsert = $conn->prepare($sqlInsert);
                $stmtInsert->bind_param("sss", $nombre, $email, $passwordHash);

                if ($stmtInsert->execute()) {
                    echo '<script>alert("Registro exitoso. Ahora puedes iniciar sesión.");</script>';
                    echo '<script>window.location.href = "../registro.html";</script>';
                } else {
                    echo '<script>alert("Error al registrar el usuario: ' . $conn->error . '");</script>';
                    echo '<script>window.location.href = "../registro.html";</script>';
                }

                $stmtInsert->close();
            }

            $stmtCheck->close();
        }
    }
} else {
    echo '<script>alert("Método no permitido.");</script>';
    echo '<script>window.location.href = "../registro.html";</script>';
}
?>
