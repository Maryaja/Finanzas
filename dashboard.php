<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Control</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</h1>

    <nav>
        <ul>
            <li><a href="registrar_entrada.php">1. Registrar Entrada</a></li>
            <li><a href="registrar_salida.php">2. Registrar Salida</a></li>
            <li><a href="ver_entradas.php">3. Ver Entradas</a></li>
            <li><a href="ver_salidas.php">4. Ver Salidas</a></li>
            <li><a href="mostrar_balance.php">5. Mostrar Balance</a></li>
            <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
    </nav>
</body>
</html>
