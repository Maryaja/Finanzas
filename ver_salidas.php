<?php
session_start();
require 'db/conexion.php';
require 'clases/Salidas.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'];

$salidas = new Salidas($db, $usuario_id);
$listaSalidas = $salidas->obtenerSalidas();

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
    <title>Ver Salidas</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Salidas Registradas</h2>

    <?php if ($mensaje_eliminacion): ?>
        <p class="mensaje-eliminacion <?php echo (strpos($mensaje_eliminacion, 'Error') === 0) ? 'error' : 'exito'; ?>"><?php echo $mensaje_eliminacion; ?></p>
    <?php endif; ?>

    <form method="post" action="eliminar_registros.php">
        <input type="hidden" name="tipo" value="salida">
        <table>
            <thead>
                <tr>
                    <th class="eliminar-col"><input type="checkbox" id="seleccionar_todas_salidas"></th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                    <th>Factura</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listaSalidas as $salida): ?>
                    <tr>
                        <td class="eliminar-col"><input type="checkbox" name="eliminar[]" value="<?php echo $salida['id']; ?>"></td>
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

        // Funcionalidad del checkbox "Seleccionar Todas" para salidas
        document.getElementById('seleccionar_todas_salidas').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('input[name="eliminar[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>

    <p><a href="dashboard.php">← Volver al menú</a></p>
</body>
</html>