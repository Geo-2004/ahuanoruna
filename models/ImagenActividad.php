<?php
require_once RUTA_BASE .'/config/database.php';

class ImagenActividad {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function guardar($id_actividad, $ruta_imagen) {
        $sql = "INSERT INTO imagenes_actividad (id_actividad, ruta_imagen)
                VALUES (:id_actividad, :ruta)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_actividad', $id_actividad);
        $stmt->bindParam(':ruta', $ruta_imagen);
        return $stmt->execute();
    }

    public function obtenerPorActividad($id_actividad) {
        $sql = "SELECT * FROM imagenes_actividad WHERE id_actividad = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id_actividad);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function eliminar($id_imagen) {
        $sql = "DELETE FROM imagenes_actividad WHERE id_imagen = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id_imagen);
        return $stmt->execute();
    }
}
