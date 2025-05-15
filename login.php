<?php
session_start();
require 'db/conexion.php';
require 'clases/Login.php';

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = new Login($db);
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    if ($login->autenticar($usuario, $contrasena)) {
        $_SESSION['usuario'] = $usuario;
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
</body>
</html>
