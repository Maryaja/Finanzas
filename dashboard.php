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
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <style>
        .dashboard-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            text-align: center;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background-color:rgb(109, 103, 103);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px var(--shadow);
            text-decoration: none;
            color: var(--text);
            transition: transform 0.2s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 255, 200, 0.2);
        }

        .card-icon {
            width: 32px;
            height: 32px;
            margin-bottom: 10px;
            color: var(--accent);
        }

        .card-title {
            font-weight: bold;
            margin-top: 10px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</h1>

        <div class="card-grid">
            <a href="registrar_entrada.php" class="card">
                <i data-lucide="arrow-down-circle" class="card-icon"></i>
                <div class="card-title">Registrar Entrada</div>
            </a>
            <a href="registrar_salida.php" class="card">
                <i data-lucide="arrow-up-circle" class="card-icon"></i>
                <div class="card-title">Registrar Salida</div>
            </a>
            <a href="ver_entradas.php" class="card">
                <i data-lucide="file-text" class="card-icon"></i>
                <div class="card-title">Ver Entradas</div>
            </a>
            <a href="ver_salidas.php" class="card">
                <i data-lucide="file-minus" class="card-icon"></i>
                <div class="card-title">Ver Salidas</div>
            </a>
            <a href="mostrar_balance.php" class="card">
                <i data-lucide="bar-chart-2" class="card-icon"></i>
                <div class="card-title">Mostrar Balance</div>
            </a>
            <a href="logout.php" class="card">
                <i data-lucide="log-out" class="card-icon"></i>
                <div class="card-title">Cerrar Sesión</div>
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>