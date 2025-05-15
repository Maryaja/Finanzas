<?php
class Entradas {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function registrarEntrada($tipo, $monto, $fecha, $factura) {
        $stmt = $this->db->prepare("INSERT INTO entradas (tipo, monto, fecha, factura) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sdss", $tipo, $monto, $fecha, $factura);
        $stmt->execute();
    }

    public function obtenerEntradas() {
        $result = $this->db->query("SELECT * FROM entradas ORDER BY fecha DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
