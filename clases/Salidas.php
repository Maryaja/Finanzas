<?php
class Salidas {
    private $db;
    private $usuarioId; 

    public function __construct($db, $usuarioId) {
        $this->db = $db;
        $this->usuarioId = $usuarioId; 
    }

    public function registrarSalida($tipo, $monto, $fecha, $factura) {
        
        $stmt = $this->db->prepare("INSERT INTO salidas (tipo, monto, fecha, factura, usuario_id) VALUES (?, ?, ?, ?, ?)");
        
        $stmt->bind_param("sdssi", $tipo, $monto, $fecha, $factura, $this->usuarioId);
        return $stmt->execute(); // Devolver el resultado de la ejecución
    }

    public function obtenerSalidas() {
       
        $stmt = $this->db->prepare("SELECT * FROM salidas WHERE usuario_id = ? ORDER BY fecha DESC");
        $stmt->bind_param("i", $this->usuarioId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>