<?php
require_once RUTA_BASE .'/config/database.php';

class LimiteReserva {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtenerPorFecha($fecha) {
        $sql = "SELECT maximo FROM limite_reservas WHERE fecha = :fecha LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['maximo'] : 2; // 👈 Límite por defecto de 2
    }
    

    public function establecer($fecha, $maximo) {
        $existe = $this->obtenerPorFecha($fecha);
        if ($existe !== null) {
            $sql = "UPDATE limite_reservas SET maximo = :maximo WHERE fecha = :fecha";
        } else {
            $sql = "INSERT INTO limite_reservas (fecha, maximo) VALUES (:fecha, :maximo)";
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':maximo', $maximo);
        return $stmt->execute();
    }
}
?>
