<?php
class Cliente {
    private $db;

    public function __construct() {
        require_once RUTA_BASE .'/config/database.php';
        $this->db = Conexion::getMessage();
    }

    public function contarClientes() {
        $sql = "SELECT COUNT(*) AS total FROM clientes";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'];
    }
}
