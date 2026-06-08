<?php
class Database {
    // // conexion Local
    // private $host = "localhost";
    // private $db_name = "sistema_evaluacion";
    // private $username = "root"; // Cambiar por tu usuario
    // private $password = "";     // Cambiar por tu contraseña
    // public $conn;

    // Conexion Remota - Hostinger
    private $host = "localhost";
    private $db_name = "u599531740_test";
    private $username = "u599531740_test_admin"; // Cambiar por tu usuario
    private $password = "Adso2026*";     // Cambiar por tu contraseña
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>