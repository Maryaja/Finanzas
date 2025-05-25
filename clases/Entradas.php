<?php
class Entradas {
    private $db;
    private $usuarioId; // Propiedad para almacenar el ID del usuario

    public function __construct($db, $usuarioId) {
        $this->db = $db;
        $this->usuarioId = $usuarioId; // Recibir el ID del usuario al instanciar la clase
    }

    public function registrarEntrada($tipo, $monto, $fecha, $factura) {
        // Modificar la consulta INSERT para incluir el usuario_id
        $stmt = $this->db->prepare("INSERT INTO entradas (tipo, monto, fecha, factura, usuario_id) VALUES (?, ?, ?, ?, ?)");
        // Bindear también el usuarioId
        $stmt->bind_param("sdssi", $tipo, $monto, $fecha, $factura, $this->usuarioId);
        return $stmt->execute(); // Devolver el resultado de la ejecución
    }

    public function obtenerEntradas() {
        // Modificar la consulta SELECT para filtrar por usuario_id
        $stmt = $this->db->prepare("SELECT * FROM entradas WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->bind_param("i", $this->usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>