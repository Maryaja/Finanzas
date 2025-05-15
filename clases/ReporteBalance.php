<?php
class ReporteBalance {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function obtenerTotalEntradas() {
        $result = $this->db->query("SELECT SUM(monto) AS total FROM entradas");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function obtenerTotalSalidas() {
        $result = $this->db->query("SELECT SUM(monto) AS total FROM salidas");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function obtenerBalance() {
        return $this->obtenerTotalEntradas() - $this->obtenerTotalSalidas();
    }

    public function obtenerEntradas() {
        $result = $this->db->query("SELECT * FROM entradas ORDER BY fecha DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerSalidas() {
        $result = $this->db->query("SELECT * FROM salidas ORDER BY fecha DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
