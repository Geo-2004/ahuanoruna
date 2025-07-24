<?php
// === MODELO: models/GaleriaDashboard.php ===
require_once RUTA_BASE .'/config/database.php';

class GaleriaDashboard {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtenerTodas() {
        $stmt = $this->conn->query("SELECT * FROM galeria_dashboard");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function agregar($url) {
        $stmt = $this->conn->prepare("INSERT INTO galeria_dashboard (url) VALUES (:url)");
        return $stmt->execute([':url' => $url]);
    }

    public function eliminar($id) {
        $stmt = $this->conn->prepare("DELETE FROM galeria_dashboard WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    public function obtenerPorId($id) {
    $stmt = $this->conn->prepare("SELECT * FROM galeria_dashboard WHERE id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
?>
