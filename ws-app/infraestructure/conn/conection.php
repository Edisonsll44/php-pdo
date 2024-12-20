<?php
class Conexion {
    private $host = 'localhost';
    private $dbname = 'postgres';
    private $user = 'postgres';
    private $password = 'toor';
    public $pdo;

    public function __construct() {
        try {
            // Crear una nueva conexión PDO
            $this->pdo = new PDO("pgsql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            // Configurar el modo de error de PDO para que lance excepciones
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    public function getConnection() {
        return $this->pdo;
    }
}
