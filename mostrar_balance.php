 <?php
session_start();
require 'db/conexion.php';
require 'clases/ReporteBalance.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$reporte = new ReporteBalance($db);
$totalEntradas = $reporte->obtenerTotalEntradas();
$totalSalidas = $reporte->obtenerTotalSalidas();
$balance = $reporte->obtenerBalance();
$entradas = $reporte->obtenerEntradas();
$salidas = $reporte->obtenerSalidas();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mostrar Balance</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
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
    <h2>Balance Financiero</h2>

    <p><strong>Total de Entradas:</strong> $<?php echo number_format($totalEntradas, 2); ?></p>
    <p><strong>Total de Salidas:</strong> $<?php echo number_format($totalSalidas, 2); ?></p>
    <p><strong>Balance:</strong> $<?php echo number_format($balance, 2); ?></p>

    <canvas id="balanceChart" width="400" height="400"></canvas>
    <script>
        var ctx = document.getElementById('balanceChart').getContext('2d');
        var balanceChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Entradas', 'Salidas'],
                datasets: [{
                    data: [<?php echo $totalEntradas; ?>, <?php echo $totalSalidas; ?>],
                    backgroundColor: ['#4CAF50', '#F44336'],
                    hoverBackgroundColor: ['#66BB6A', '#EF5350']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

    <h3>Entradas</h3>
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
            <?php foreach ($entradas as $entrada): ?>
                <tr>
                    <td><?php echo htmlspecialchars($entrada['tipo']); ?></td>
                    <td>$<?php echo number_format($entrada['monto'], 2); ?></td>
                    <td><?php echo $entrada['fecha']; ?></td>
                    <td>
                        <img src="<?php echo $entrada['factura']; ?>" alt="Factura" onclick="mostrarImagen(this.src)">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Salidas</h3>
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
            <?php foreach ($salidas as $salida): ?>
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
<form action="generar_pdf.php" method="post" style="margin-bottom: 20px;">
    <button type="submit">📄 Descargar Balance en PDF</button>
</form>

    <p><a href="dashboard.php">← Volver al menú</a></p>
</body>
</html>