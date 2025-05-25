<?php
session_start();
require 'db/conexion.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar si el usuario ya existe
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $mensaje = "El nombre de usuario ya existe.";
    } else {
        // Encriptar la contraseña
        $hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Insertar nuevo usuario
        $stmt = $db->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $hash);
        if ($stmt->execute()) {
            $_SESSION['usuario'] = $usuario;
            $_SESSION['usuario_id'] = $stmt->insert_id; // Guardar el ID del nuevo usuario
            header('Location: dashboard.php');
            exit;
        } else {
            $mensaje = "Error al registrar el usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Crear una nueva cuenta</h2>

    <?php if ($mensaje): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST" action="registrar_usuario.php">
        <label for="usuario">Nombre de Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br><br>

        <button type="submit">Registrarse</button>
    </form>

    <p><a href="login.php">← Ya tengo una cuenta</a></p>
</body>
</html>
