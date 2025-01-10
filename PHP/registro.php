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
        echo "Por favor, completa todos los campos.";
        exit;
    }

    // Validar que las contraseñas coincidan
    if ($password !== $confirmPassword) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Cifrar la contraseña
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Verificar si el correo ya existe
    $sqlCheck = "SELECT id FROM usuarios WHERE correo = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        echo "El correo ya está registrado.";
        exit;
    }

    // Insertar el nuevo usuario en la base de datos
    $sqlInsert = "INSERT INTO usuarios (nombre_completo, correo, contrasena) VALUES (?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("sss", $nombre, $email, $passwordHash);

    if ($stmtInsert->execute()) {
        echo "Registro exitoso. Ahora puedes iniciar sesión.";
        header("Location:../login.html");
        exit;
    } else {
        echo "Error al registrar el usuario: " . $conn->error;
    }

    $stmtCheck->close();
    $stmtInsert->close();
} else {
    echo "Método no permitido.";
}
?>
