<?php
// Archivo: login.php
session_start();
require 'db/conexion.php';
require 'clases/Login.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new Login($db);
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    // Llamar a la función autenticar y guardar el resultado (que ahora será el usuario_id o false)
    $usuario_id = $login->autenticar($usuario, $contrasena);

    if ($usuario_id) {
        $_SESSION['usuario'] = $usuario; // Guardar el nombre de usuario (opcional)
        $_SESSION['usuario_id'] = $usuario_id; // Guardar el ID del usuario en la sesión
        header('Location: dashboard.php');
        exit;
    } else {
        $mensaje = "Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form method="POST" action="login.php">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required><br><br>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required><br><br>

        <button type="submit">Ingresar</button>
    </form>

    <?php if ($mensaje): ?>
        <p style="color:red;"><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <p><a href="registrar_usuario.php">¿No tienes cuenta? Regístrate aquí</a></p>
</body>
</html>