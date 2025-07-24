<?php
require_once RUTA_BASE .'/config/database.php';

class Factura {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    // Crear una nueva factura
    public function crear($id_reserva, $total, $detalle, $estado = 'pendiente') {
    $sql = "INSERT INTO facturas (id_reserva, fecha_emision, total, detalle, estado)
            VALUES (:id_reserva, CURDATE(), :total, :detalle, :estado)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_reserva', $id_reserva, PDO::PARAM_INT);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':detalle', $detalle);
    $stmt->bindParam(':estado', $estado);
    return $stmt->execute();

    }

    // Obtener facturas por usuario
    public function obtenerPorUsuario($id_usuario) {
        $sql = "SELECT f.*, a.nombre AS actividad, p.metodo_pago, p.fecha_pago, p.monto_total,
                       u.nombres, u.apellidos
                FROM facturas f
                INNER JOIN pagos p ON f.id_reserva = p.id_reserva
                INNER JOIN reservas r ON f.id_reserva = r.id_reserva
                INNER JOIN actividades a ON r.id_actividad = a.id_actividad
                INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
                WHERE r.id_usuario = :id_usuario
                ORDER BY f.fecha_emision DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una factura por su ID
    // Obtener una factura por su ID
public function obtenerPorId($id_factura) {
    $sql = "SELECT f.id_factura, f.total, f.detalle, f.fecha_emision,
               a.nombre AS actividad, r.fecha_actividad, r.cantidad_personas,
               u.nombres, u.apellidos, u.cedula, u.correo, u.telefono,
               p.metodo_pago, p.fecha_pago, p.monto_total
        FROM facturas f
        INNER JOIN reservas r ON f.id_reserva = r.id_reserva
        INNER JOIN actividades a ON r.id_actividad = a.id_actividad
        INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
        LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
        WHERE f.id_factura = :id_factura";

    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


    // Obtener todas las facturas (para el admin)
    public function obtenerTodas() {
        $sql = "SELECT f.*, u.nombres, u.apellidos, a.nombre AS actividad
                FROM facturas f
                INNER JOIN reservas r ON f.id_reserva = r.id_reserva
                INNER JOIN usuarios u ON r.id_usuario = u.id_usuario
                INNER JOIN actividades a ON r.id_actividad = a.id_actividad
                ORDER BY f.fecha_emision DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar el estado de la factura (por ejemplo: 'Pendiente', 'Pagada')
    public function actualizarEstado($id_factura, $nuevo_estado) {
        $sql = "UPDATE facturas SET estado = :estado WHERE id_factura = :id_factura";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':estado', $nuevo_estado);
        $stmt->bindParam(':id_factura', $id_factura, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
