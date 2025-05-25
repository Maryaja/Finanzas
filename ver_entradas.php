<?php
session_start();
require 'db/conexion.php';
require 'clases/Entradas.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'];

$entradas = new Entradas($db, $usuario_id);
$listaEntradas = $entradas->obtenerEntradas();

$mensaje_eliminacion = "";
if (isset($_SESSION['mensaje_eliminacion'])) {
    $mensaje_eliminacion = $_SESSION['mensaje_eliminacion'];
    unset($_SESSION['mensaje_eliminacion']); // Limpiar el mensaje de sesión
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Entradas</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        th.eliminar-col, td.eliminar-col {
            width: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Entradas Registradas</h2>

    <?php if ($mensaje_eliminacion): ?>
        <p class="mensaje-eliminacion <?php echo (strpos($mensaje_eliminacion, 'Error') === 0) ? 'error' : 'exito'; ?>"><?php echo $mensaje_eliminacion; ?></p>
    <?php endif; ?>

    <form method="post" action="eliminar_registros.php">
        <input type="hidden" name="tipo" value="entrada">
        <table>
            <thead>
                <tr>
                    <th class="eliminar-col"><input type="checkbox" id="seleccionar_todas_entradas"></th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Factura</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaEntradas as $entrada): ?>
                    <tr>
                        <td class="eliminar-col"><input type="checkbox" name="eliminar[]" value="<?php echo $entrada['id']; ?>"></td>
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
        <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar los registros seleccionados?')">Eliminar Seleccionados</button>
    </form>

    <div id="modal" class="modal" onclick="cerrarModal()">
        <span class="close">&times;</span>
        <img class="modal-content" id="imagenAmpliada">
    </div>

    <script>
        function mostrarImagen(src) {
            var modal = document.getElementById("modal");
            var modalImg = document.getElementById("imagenAmpliada");
            modalImg.src = src;
            modal.style.display = "block";
            modalImg.style.marginTop = Math.max(0, (window.innerHeight - modalImg.offsetHeight) / 2) + "px"; // Centrar verticalmente
        }

        function cerrarModal() {
            document.getElementById("modal").style.display = "none";
        }

        // Cerrar el modal haciendo clic fuera de la imagen
        window.onclick = function(event) {
            var modal = document.getElementById("modal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Funcionalidad del checkbox "Seleccionar Todas" para entradas
        document.getElementById('seleccionar_todas_entradas').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="eliminar[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>

    <p><a href="dashboard.php">← Volver al menú</a></p>
</body>
</html>