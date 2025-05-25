<?php
class ReporteBalance {
    private $db;
    private $usuarioId; // Propiedad para almacenar el ID del usuario

    public function __construct($db, $usuarioId) {
        $this->db = $db;
        $this->usuarioId = $usuarioId; // Recibir el usuarioId al instanciar la clase
    }

    public function obtenerTotalEntradas() {
        $stmt = $this->db->prepare("SELECT SUM(monto) AS total FROM entradas WHERE usuario_id = ?");
        $stmt->bind_param("i", $this->usuarioId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function obtenerTotalSalidas() {
        $stmt = $this->db->prepare("SELECT SUM(monto) AS total FROM salidas WHERE usuario_id = ?");
        $stmt->bind_param("i", $this->usuarioId);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function obtenerBalance() {
        return $this->obtenerTotalEntradas() - $this->obtenerTotalSalidas();
    }

    public function obtenerEntradas() {
        $stmt = $this->db->prepare("SELECT * FROM entradas WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->bind_param("i", $this->usuarioId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerSalidas() {
        $stmt = $this->db->prepare("SELECT * FROM salidas WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->bind_param("i", $this->usuarioId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>