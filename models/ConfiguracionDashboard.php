<?php
require_once RUTA_BASE .'/config/database.php';

class ConfiguracionDashboard {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
        if (!$this->conn) {
            throw new Exception("No se pudo conectar a la base de datos");
        }
    }

    // Obtener configuración actual
    public function obtenerConfiguracion() {
        $sql = "SELECT * FROM configuracion_dashboard LIMIT 1";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return is_array($result) ? $result : []; // Siempre devolver un array
    }

    // Normaliza los datos para que no haya claves faltantes
    private function normalizarDatos($datos) {
        return [
            ':bienvenida_titulo' => $datos['bienvenida_titulo'] ?? '',
            ':bienvenida_texto' => $datos['bienvenida_texto'] ?? '',
            ':clima_ciudad' => $datos['clima_ciudad'] ?? '',
            ':mapa_latitud' => $datos['mapa_latitud'] ?? '',
            ':mapa_longitud' => $datos['mapa_longitud'] ?? '',
            ':video_url' => $datos['video_url'] ?? ''
        ];
    }

    // Guardar o actualizar la configuración
    public function guardarConfiguracion($datos) {
        $datos = $this->normalizarDatos($datos); // Normalizar para evitar valores nulos

        // Verificar si existe
        $sqlCheck = "SELECT id FROM configuracion_dashboard LIMIT 1";
        $stmtCheck = $this->conn->query($sqlCheck);
        $existe = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($existe) {
            // Actualizar
            $sql = "UPDATE configuracion_dashboard SET 
                        bienvenida_titulo = :bienvenida_titulo, 
                        bienvenida_texto = :bienvenida_texto, 
                        clima_ciudad = :clima_ciudad, 
                        mapa_latitud = :mapa_latitud, 
                        mapa_longitud = :mapa_longitud, 
                        video_url = :video_url 
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $datos[':id'] = $existe['id'];
            return $stmt->execute($datos);
        } else {
            // Insertar
            $sql = "INSERT INTO configuracion_dashboard 
                    (bienvenida_titulo, bienvenida_texto, clima_ciudad, mapa_latitud, mapa_longitud, video_url)
                    VALUES (:bienvenida_titulo, :bienvenida_texto, :clima_ciudad, :mapa_latitud, :mapa_longitud, :video_url)";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($datos);
        }
    }
    
}
?>
