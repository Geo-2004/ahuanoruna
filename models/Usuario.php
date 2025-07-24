<?php
require_once RUTA_BASE .'/config/database.php';

class Usuario {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->conectar();
    }

    public function registrar($nombres, $apellidos, $cedula, $correo, $telefono, $contrasena) {
        $sql = "INSERT INTO usuarios (nombres, apellidos, cedula, correo, telefono, contrasena)
                VALUES (:nombres, :apellidos, :cedula, :correo, :telefono, :contrasena)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        $hash = password_hash($contrasena, PASSWORD_DEFAULT); // Usamos sin tilde
        $stmt->bindParam(':contrasena', $hash);
        return $stmt->execute();
    }
    
    public function login($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo AND estado = 'activo'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        if ($stmt->rowCount() === 1) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($contrasena, $usuario['contrasena'])) {
                return $usuario;
            }
        }
        return false;
    }
    
    public function obtenerTodos() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function obtenerPorId($id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function actualizar($id, $nombres, $apellidos, $correo, $telefono, $rol, $estado) {
        $sql = "UPDATE usuarios SET nombres = :nombres, apellidos = :apellidos, correo = :correo,
                telefono = :telefono, rol = :rol, estado = :estado WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombres', $nombres);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':correo', $correo);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':rol', $rol);
        $stmt->bindParam(':estado', $estado);
        return $stmt->execute();
    }
    
    public function eliminar($id) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function buscarPorCedula($cedula) {
    $sql = "SELECT * FROM usuarios WHERE cedula LIKE :cedula";
    $stmt = $this->conn->prepare($sql);
    $valor = "%$cedula%";
    $stmt->bindParam(':cedula', $valor);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function buscarPorNombreOCedula($texto) {
    $sql = "SELECT * FROM usuarios 
            WHERE nombres LIKE :texto OR apellidos LIKE :texto OR cedula LIKE :texto";
    $stmt = $this->conn->prepare($sql);
    $valor = "%$texto%";
    $stmt->bindParam(':texto', $valor);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
public function buscarPorCorreo($correo) {
    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$correo]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function guardarTokenRecuperacion($id_usuario, $token) {
    $sql = "UPDATE usuarios SET token_recuperacion = ?, token_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE id_usuario = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$token, $id_usuario]);
}

public function buscarPorToken($token) {
    $sql = "SELECT * FROM usuarios WHERE token_recuperacion = ? AND token_expira > NOW()";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function actualizarContrasena($id_usuario, $nueva_contrasena) {
    $hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    $sql = "UPDATE usuarios SET contrasena = ?, token_recuperacion = NULL, token_expira = NULL WHERE id_usuario = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$hash, $id_usuario]);
}

public function eliminarTokenRecuperacion($id_usuario) {
    $sql = "UPDATE usuarios SET token_recuperacion = NULL, token_expira = NULL WHERE id_usuario = ?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$id_usuario]);
}
    
}
?>
