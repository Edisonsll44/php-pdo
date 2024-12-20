<?php
require_once '../conn/conection.php';

class TestConexion {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function testConexion() {
        $pdo = $this->conexion->getConnection();

        if ($pdo) {
            // Realizar una consulta simple para verificar la conexión
            $query = "SELECT * from persona"; // Consulta simple
            $result = $pdo->query($query);

            if ($result) {
                echo "¡Conexión exitosa a la base de datos!";
            } else {
                echo "Error al ejecutar la consulta.";
            }
        } else {
            echo "Error al conectar a la base de datos.";
        }
    }
}

// Crear una instancia de TestConexion y probar la conexión
$test = new TestConexion();
$test->testConexion();
?>