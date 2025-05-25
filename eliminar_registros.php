<?php
session_start();
require 'db/conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar']) && is_array($_POST['eliminar'])) {
    $registros_a_eliminar = $_POST['eliminar'];
    $tipo = $_POST['tipo'];
    $tabla = '';

    if ($tipo === 'entrada') {
        $tabla = 'entradas';
    } elseif ($tipo === 'salida') {
        $tabla = 'salidas';
    }

    if (!empty($tabla) && !empty($registros_a_eliminar)) {
        $placeholders = implode(',', array_fill(0, count($registros_a_eliminar), '?'));
        $sql = "DELETE FROM $tabla WHERE id IN ($placeholders) AND usuario_id = ?";
        $stmt = $db->prepare($sql);

        if ($stmt) {
            // Construir la cadena de tipos para bind_param
            $tipos = str_repeat('i', count($registros_a_eliminar)) . 'i';
            // Crear un array con los parámetros para bind_param
            $params = [...$registros_a_eliminar, $usuario_id];
            // Usar call_user_func_array para vincular los parámetros dinámicamente
            $stmt->bind_param($tipos, ...$params);

            if ($stmt->execute()) {
                $_SESSION['mensaje_eliminacion'] = 'Registros eliminados correctamente.';
            } else {
                $_SESSION['mensaje_eliminacion'] = 'Error al eliminar los registros: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['mensaje_eliminacion'] = 'Error al preparar la consulta: ' . $db->error;
        }
    } elseif (empty($registros_a_eliminar)) {
        $_SESSION['mensaje_eliminacion'] = 'No se seleccionaron registros para eliminar.';
    } else {
        $_SESSION['mensaje_eliminacion'] = 'Tipo de registro no válido.';
    }

    if ($tipo === 'entrada') {
        header('Location: ver_entradas.php');
    } elseif ($tipo === 'salida') {
        header('Location: ver_salidas.php');
    }
    exit;
} else {
    header('Location: dashboard.php'); // Si no se recibieron IDs para eliminar
    exit;
}
?>