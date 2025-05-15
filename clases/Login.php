<?php
class Login {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function autenticar($usuario, $contrasena) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();

        if ($usuario && password_verify($contrasena, $usuario['password'])) {
            return true;
        }
        return false;
    }
}
?>
