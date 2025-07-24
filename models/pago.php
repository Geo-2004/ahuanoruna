<?php
require_once RUTA_BASE .'/config/database.php';

class Pago {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function registrar($id_reserva, $monto, $metodo_pago, $comprobante, $numero_comprobante) {
        $sql = "INSERT INTO pagos (id_reserva, monto_total, metodo_pago, fecha_pago, imagen_comprobante, numero_comprobante, estado)
                VALUES (:id_reserva, :monto, :metodo_pago, CURDATE(), :comprobante, :numero, 'pendiente')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->bindParam(':monto', $monto);
        $stmt->bindParam(':metodo_pago', $metodo_pago);
        $stmt->bindParam(':comprobante', $comprobante);
        $stmt->bindParam(':numero', $numero_comprobante);
        return $stmt->execute();
    }

    public function existePago($id_reserva) {
        $sql = "SELECT COUNT(*) FROM pagos WHERE id_reserva = :id_reserva";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_reserva', $id_reserva);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Otros métodos para listar, eliminar pagos, etc.


    public function obtenerTodos() {
        $sql = "SELECT p.*, r.fecha_actividad, u.nombres, u.apellidos
                FROM pagos p
                JOIN reservas r ON p.id_reserva = r.id_reserva
                JOIN usuarios u ON r.id_usuario = u.id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id_pago) {
        $sql = "DELETE FROM pagos WHERE id_pago = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id_pago);
        return $stmt->execute();
    }
    
    public function obtenerIngresosHoy() {
    $sql = "SELECT SUM(monto_total) AS total FROM pagos 
            WHERE fecha_pago = CURDATE() AND estado = 'confirmado'";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultado['total'] ?? 0;

}
public function actualizarEstadoPorReserva($id_reserva, $nuevoEstado) {
    $sql = "UPDATE pagos SET estado = :estado WHERE id_reserva = :id_reserva";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':estado', $nuevoEstado);
    $stmt->bindParam(':id_reserva', $id_reserva);
    return $stmt->execute();
}
public function obtenerPorReserva($id_reserva) {
    $sql = "SELECT * FROM pagos WHERE id_reserva = :id_reserva LIMIT 1";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_reserva', $id_reserva);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


}
?>