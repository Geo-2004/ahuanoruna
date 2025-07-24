<?php
require_once RUTA_BASE .'/config/database.php';

class CuentaBancaria {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtenerTodasActivas() {
        $sql = "SELECT * FROM cuentas_bancarias WHERE estado = 'activa'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerTodas() {
        $sql = "SELECT * FROM cuentas_bancarias";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($banco, $numero_cuenta, $tipo_cuenta, $nombre_titular, $estado) {
        $sql = "INSERT INTO cuentas_bancarias (banco, numero_cuenta, tipo_cuenta, nombre_titular, estado)
                VALUES (:banco, :numero_cuenta, :tipo_cuenta, :nombre_titular, :estado)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':banco', $banco);
        $stmt->bindParam(':numero_cuenta', $numero_cuenta);
        $stmt->bindParam(':tipo_cuenta', $tipo_cuenta);
        $stmt->bindParam(':nombre_titular', $nombre_titular);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM cuentas_bancarias WHERE id_cuenta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $banco, $numero_cuenta, $tipo_cuenta, $nombre_titular, $estado) {
        $sql = "UPDATE cuentas_bancarias SET banco = :banco, numero_cuenta = :numero_cuenta,
                tipo_cuenta = :tipo_cuenta, nombre_titular = :nombre_titular, estado = :estado
                WHERE id_cuenta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':banco', $banco);
        $stmt->bindParam(':numero_cuenta', $numero_cuenta);
        $stmt->bindParam(':tipo_cuenta', $tipo_cuenta);
        $stmt->bindParam(':nombre_titular', $nombre_titular);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $sql = "DELETE FROM cuentas_bancarias WHERE id_cuenta = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>