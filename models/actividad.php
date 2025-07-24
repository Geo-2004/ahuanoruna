<?php
require_once RUTA_BASE .'/config/database.php';

class Actividad {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtenerTodas() {
        $sql = "SELECT * FROM actividades WHERE estado = 'disponible'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $descripcion, $descripcion_larga, $precio, $duracion, $estado, $imagen) {
        $sql = "INSERT INTO actividades (nombre, descripcion, descripcion_larga, precio, duracion, estado, imagen)
                VALUES (:nombre, :descripcion, :descripcion_larga, :precio, :duracion, :estado, :imagen)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':descripcion_larga', $descripcion_larga);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function obtenerTodasAdmin() {
        $sql = "SELECT * FROM actividades";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function actualizar($id, $nombre, $descripcion, $precio, $duracion, $estado, $imagen) {
        $sql = "UPDATE actividades SET 
                    nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    duracion = :duracion,
                    estado = :estado,
                    imagen = :imagen
                WHERE id_actividad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':duracion', $duracion);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':imagen', $imagen);
        return $stmt->execute();
    }

    public function eliminar($id) {
        $sql = "DELETE FROM actividades WHERE id_actividad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function obtenerPorId($id) {
        $sql = "SELECT * FROM actividades WHERE id_actividad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Método corregido para que no cause error
    public function listarTodas() {
        $sql = "SELECT * FROM actividades";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
