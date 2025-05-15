<?php
$host = "localhost";
$usuario = "root";
$contrasena = ""; // Deja esto vacío si no tienes contraseña en XAMPP
$base_de_datos = "finanzas";

// Crear conexión
$db = new mysqli($host, $usuario, $contrasena, $base_de_datos);

// Verificar conexión
if ($db->connect_error) {
    die("Conexión fallida: " . $db->connect_error);
}
?>
