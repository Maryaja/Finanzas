<?php
session_start();
require 'db/conexion.php';
require 'clases/Salidas.php';

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$salidas = new Salidas($db);
$listaSalidas = $salidas->obtenerSalidas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Salidas</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ccc;
            text-align: center;
        }

        img {
            width: 100px;
            cursor: pointer;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.8);
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 80%;
        }

        .close {
            position: absolute;
            top: 30px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Salidas Registradas</h2>

    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Fecha</th>
                <th>Factura</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($listaSalidas as $salida): ?>
                <tr>
                    <td><?php echo htmlspecialchars($salida['tipo']); ?></td>
                    <td>$<?php echo number_format($salida['monto'], 2); ?></td>
                    <td><?php echo $salida['fecha']; ?></td>
                    <td>
                        <img src="<?php echo $salida['factura']; ?>" alt="Factura" onclick="mostrarImagen(this.src)">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div id="modal" class="modal" onclick="cerrarModal()">
        <span class="close">&times;</span>
        <img class="modal-content" id="imagenAmpliada">
    </div>

    <script>
        function mostrarImagen(src) {
            document.getElementById("imagenAmpliada").src = src;
            document.getElementById("modal").style.display = "block";
        }

        function cerrarModal() {
            document.getElementById("modal").style.display = "none";
        }
    </script>

    <p><a href="dashboard.php">← Volver al menú</a></p>
</body>
</html>
