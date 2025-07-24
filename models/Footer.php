<?php
require_once RUTA_BASE .'/config/database.php';

class Footer {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtener() {
        $sql = "SELECT * FROM footer_config LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($datos) {
        $sql = "UPDATE footer_config SET telefono = :telefono, correo = :correo, direccion = :direccion,
                facebook = :facebook, instagram = :instagram, whatsapp = :whatsapp WHERE id = 1";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($datos);
    }
}
