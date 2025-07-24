<?php
require_once RUTA_BASE .'/config/database.php';

class Configuracion {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function obtenerFondo($vista) {
        $sql = "SELECT fondo FROM configuracion WHERE vista = :vista LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':vista', $vista);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado['fondo'] : null;
    }

    public function actualizarFondo($vista, $ruta) {
        // Verifica si ya existe
        $sql = "SELECT id_config FROM configuracion WHERE vista = :vista";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':vista', $vista);
        $stmt->execute();

        if ($stmt->fetch()) {
            // Actualiza
            $sql = "UPDATE configuracion SET fondo = :ruta WHERE vista = :vista";
        } else {
            // Inserta nuevo
            $sql = "INSERT INTO configuracion (vista, fondo) VALUES (:vista, :ruta)";
        }

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':vista', $vista);
        $stmt->bindParam(':ruta', $ruta);
        return $stmt->execute();
    }
}
?>
