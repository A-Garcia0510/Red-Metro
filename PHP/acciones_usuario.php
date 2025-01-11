<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'No has iniciado sesión.']);
    exit;
}

// Incluir el archivo de conexión a la base de datos
require 'conexion.php';

// Obtener el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Verificar si se recibió una acción
if (!isset($_POST['accion'])) {
    echo json_encode(['error' => 'Acción no especificada.']);
    exit;
}

// Procesar la acción recibida
$accion = $_POST['accion'];

if ($accion === 'editar_perfil') {
    // Validar y recibir los datos del usuario
    $nombre_completo = trim($_POST['nombre_completo'] ?? '');
    $correo = trim($_POST['correo'] ?? '');

    if (empty($nombre_completo) || empty($correo)) {
        echo json_encode(['error' => 'Los campos no pueden estar vacíos.']);
        exit;
    }

    // Actualizar el perfil del usuario en la base de datos
    $sql = "UPDATE usuarios SET nombre_completo = ?, correo = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $nombre_completo, $correo, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Perfil actualizado correctamente.']);
    } else {
        echo json_encode(['error' => 'Error al actualizar el perfil.']);
    }

    $stmt->close();

} elseif ($accion === 'cambiar_contrasena') {
    // Validar y recibir las contraseñas
    $contrasena_actual = trim($_POST['contrasena_actual'] ?? '');
    $contrasena_nueva = trim($_POST['contrasena_nueva'] ?? '');

    if (empty($contrasena_actual) || empty($contrasena_nueva)) {
        echo json_encode(['error' => 'Los campos no pueden estar vacíos.']);
        exit;
    }

    // Verificar la contraseña actual
    $sql = "SELECT contrasena FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        echo json_encode(['error' => 'Usuario no encontrado.']);
        $stmt->close();
        exit;
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($contrasena_actual, $user['contrasena'])) {
        echo json_encode(['error' => 'La contraseña actual es incorrecta.']);
        exit;
    }

    // Actualizar la contraseña con la nueva
    $contrasena_nueva_hash = password_hash($contrasena_nueva, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET contrasena = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $contrasena_nueva_hash, $user_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => 'Contraseña actualizada correctamente.']);
    } else {
        echo json_encode(['error' => 'Error al actualizar la contraseña.']);
    }

    $stmt->close();

} else {
    echo json_encode(['error' => 'Acción no reconocida.']);
    exit;
}

// Cerrar la conexión
$conn->close();
