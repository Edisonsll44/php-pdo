<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../infraestructure/conn/conection.php';
require_once '../infraestructure/repositories/personRepository.php';
require_once '../logic/loginService.php';
require_once '../logic/dto/loginDto.php';


$conexion = new Conexion();
$pdo = $conexion->getConnection();
$repository = new PersonaRepository($pdo);

$loginService = new LoginService();
$loginService->setLoginRepository($repository);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
        if(isset($data['usuario'], $data['clave'])){
            $loginDto = new LoginDTO(
                $data['usuario'],
                $data['clave']
            );

            $response = $loginService->login($loginDto);

            // Estructura de respuesta
            if ($response['success']) {
                http_response_code(200);
                echo json_encode([
                    'success' => true,
                    'message' => 'Login exitoso.',
                ]);
            } else {
                http_response_code(404);
                echo json_encode([
                    'success' => false,
                    'message' => $response['message']
                ]);
            }
        } else {
            http_response_code(4004);
            echo json_encode([
                'success' => false,
                'message' => 'Datos de usuario y clave son requeridos.'
            ]);
        }
    } else {
    // Respuesta para métodos no permitidos
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}


?>