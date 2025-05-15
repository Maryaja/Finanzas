<?php
class Salidas {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrarSalida($tipo, $monto, $fecha, $factura) {
        $stmt = $this->db->prepare("INSERT INTO salidas (tipo, monto, fecha, factura) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $tipo, $monto, $fecha, $factura);
        $stmt->execute();
    }

    public function obtenerSalidas() {
        $result = $this->db->query("SELECT * FROM salidas ORDER BY fecha DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
