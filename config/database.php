<?php
class Database {
    private $host = "localhost";
    private $db_name = "ahuanoruna";
    private $username = "ahuano_user";
    private $password = "Ahuano_runa_2025";
    public $conn;  

    public function conectar() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>