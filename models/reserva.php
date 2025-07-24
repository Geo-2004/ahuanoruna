<?php
require_once RUTA_BASE .'/config/database.php';
require_once RUTA_BASE .'/models/Pago.php';

$pagoModel = new Pago();
$ingresosHoy = $pagoModel->obtenerIngresosHoy();


class Reserva {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

     public function crear($idActividad, $fechaActividad, $cantidad, $idUsuario, $fechaReserva) {
 
    $fechaReserva = date('Y-m-d'); 
    $sql = "INSERT INTO reservas (id_actividad, fecha_reserva, fecha_actividad, cantidad_personas, id_usuario)
            VALUES (:id_actividad, :fecha_reserva, :fecha_actividad, :cantidad, :id_usuario)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id_actividad', $idActividad);
    $stmt->bindParam(':fecha_reserva', $fechaReserva);
    $stmt->bindParam(':fecha_actividad', $fechaActividad);
    $stmt->bindParam(':cantidad', $cantidad);
    $stmt->bindParam(':id_usuario', $idUsuario);
    $stmt->execute();
    return $this->conn->lastInsertId();
}


   public function obtenerPorId($id) {
        $sql = "SELECT * FROM reservas WHERE id_reserva = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    // Otros métodos (actualizar, eliminar, obtener todas, etc.)

    // Actualizar reserva
    public function actualizar($id, $fecha_actividad, $cantidad_personas, $estado) {
        $sql = "UPDATE reservas SET fecha_actividad = :fecha, cantidad_personas = :cantidad, estado = :estado
                WHERE id_reserva = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':fecha', $fecha_actividad);
        $stmt->bindParam(':cantidad', $cantidad_personas);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }

    // Eliminar reserva (maneja clave foránea)
    public function eliminar($id) {
    try {
        // 1. Obtener nombres de imágenes de comprobante (si existen)
        $sqlImagenes = "SELECT imagen_comprobante FROM pagos WHERE id_reserva = :id";
        $stmtImg = $this->conn->prepare($sqlImagenes);
        $stmtImg->bindParam(':id', $id);
        $stmtImg->execute();
        $imagenes = $stmtImg->fetchAll(PDO::FETCH_ASSOC);

        // 2. Eliminar archivos de imagen del servidor
        foreach ($imagenes as $img) {
            if (!empty($img['imagen_comprobante'])) {
                $ruta = 'public/images/comprobantes/' . $img['imagen_comprobante']; // <-- AJUSTA ESTA RUTA
                if (file_exists($ruta)) {
                    unlink($ruta); // Borra el archivo del servidor
                }
            }
        }

        // 3. Eliminar facturas relacionadas
        $sqlFacturas = "DELETE FROM facturas WHERE id_reserva = :id";
        $stmtFact = $this->conn->prepare($sqlFacturas);
        $stmtFact->bindParam(':id', $id);
        $stmtFact->execute();

        // 4. Eliminar pagos relacionados
        $sqlPagos = "DELETE FROM pagos WHERE id_reserva = :id";
        $stmtPagos = $this->conn->prepare($sqlPagos);
        $stmtPagos->bindParam(':id', $id);
        $stmtPagos->execute();

        // 5. Finalmente, eliminar la reserva
        $sqlReserva = "DELETE FROM reservas WHERE id_reserva = :id";
        $stmtReserva = $this->conn->prepare($sqlReserva);
        $stmtReserva->bindParam(':id', $id);
        return $stmtReserva->execute();

    } catch (PDOException $e) {
        throw new Exception("Error al eliminar la reserva: " . $e->getMessage());
    }
}


    // Contar reservas por fecha
    public function contarPorFecha($fecha) {
        $sql = "SELECT COUNT(*) AS total FROM reservas WHERE fecha_actividad = :fecha";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['total'] : 0;
    }

    // Cambiar estado de reserva
    public function cambiarEstado($id_reserva, $estado) {
        $sql = "UPDATE reservas SET estado = :estado WHERE id_reserva = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':id', $id_reserva);
        return $stmt->execute();
    }

    // Obtener reservas de un cliente con info de pagos
    public function obtenerReservasPorCliente($id_usuario) {
        $sql = "SELECT r.id_reserva, a.nombre AS actividad, r.fecha_actividad, 
                       r.cantidad_personas, r.estado, p.metodo_pago, p.monto_total
                FROM reservas r
                JOIN actividades a ON r.id_actividad = a.id_actividad
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                WHERE r.id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Contar reservas hechas hoy
    public function contarReservasHoy() {
        $hoy = date('Y-m-d');
        $sql = "SELECT COUNT(*) AS total FROM reservas WHERE fecha_reserva = :fecha";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $hoy);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['total'] : 0;
    }

    // Sumar ingresos confirmados de hoy
    public function sumarIngresosHoy() {
        $hoy = date('Y-m-d');
        $sql = "SELECT SUM(p.monto_total) AS total FROM reservas r
                JOIN pagos p ON r.id_reserva = p.id_reserva
                WHERE r.fecha_reserva = :fecha AND p.estado = 'confirmado'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $hoy);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res['total'] ?? 0;
    }

    // Contar clientes únicos que han reservado
    public function contarClientes() {
        $sql = "SELECT COUNT(DISTINCT id_usuario) AS total FROM reservas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ? $res['total'] : 0;
    }
    public function obtenerTodas() {
        $sql = "SELECT r.*, a.nombre AS actividad, u.nombres, u.apellidos, p.numero_comprobante, p.imagen_comprobante
                FROM reservas r
                JOIN actividades a ON r.id_actividad = a.id_actividad
                JOIN usuarios u ON r.id_usuario = u.id_usuario
                LEFT JOIN pagos p ON r.id_reserva = p.id_reserva
                ORDER BY r.fecha_actividad DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
