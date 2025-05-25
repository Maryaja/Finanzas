<?php
session_start();
require 'db/conexion.php';
require 'clases/Entradas.php';

// Verificar si el usuario ha iniciado sesión y obtener el usuario_id
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'];

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $monto = $_POST['monto'];
    $fecha = $_POST['fecha'];

    // Guardar la imagen de la factura
    $nombreArchivo = $_FILES['factura']['name'];
    $rutaTemporal = $_FILES['factura']['tmp_name'];
    $rutaDestino = 'uploads/' . basename($nombreArchivo);

    if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
        // Instanciar la clase Entradas PASANDO la conexión y el usuario_id
        $entrada = new Entradas($db, $usuario_id);
        $entrada->registrarEntrada($tipo, $monto, $fecha, $rutaDestino);
        $mensaje = "Entrada registrada correctamente.";
    } else {
        $mensaje = "Error al subir la imagen de la factura.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Entrada</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Registrar Nueva Entrada</h2>

    <?php if ($mensaje): ?>
        <p><?php echo $mensaje; ?></p>
    <?php endif; ?>

    <form method="POST" action="registrar_entrada.php" enctype="multipart/form-data">
        <label for="tipo">Tipo de Entrada:</label>
        <input type="text" name="tipo" required><br><br>

        <label for="monto">Monto:</label>
        <input type="number" step="0.01" name="monto" required><br><br>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" required><br><br>

        <label for="factura">Factura (imagen):</label>
        <input type="file" name="factura" accept="image/*" required><br><br>

        <button type="submit">Registrar Entrada</button>
    </form>

    <p><a href="dashboard.php">← Volver al menú</a></p>
</body>
</html>