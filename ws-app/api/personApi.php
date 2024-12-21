<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../infraestructure/conn/conection.php';
require_once '../infraestructure/repositories/personRepository.php';
require_once '../logic/personService.php';

$conexion = new Conexion();
$pdo = $conexion->getConnection();
$repository = new PersonaRepository($pdo);

$personaService = new PersonaService();
$personaService->setPersonaRepository($repository);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Manejo de las solicitudes
switch ($requestMethod) {
    case 'GET':
        if (isset($requestUri[2])) {
            
            // Obtener una persona por CI
            $ci_persona = $requestUri[2];
            $persona = $personaService->getPersona($ci_persona);
            if ($persona) {
                echo json_encode($persona);
            } else {

                http_response_code(404);
                echo json_encode(['message' => 'Persona no encontrada']);
            }
        } else {
            // Obtener todas las personas
            $personas = $personaService->getPersonas();
            echo json_encode($personas);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

         // Verifica que los datos necesarios estén presentes
        if (isset($data['ci'], $data['nombre_persona'], $data['apellido_persona'], $data['clave_persona'], $data['correo_persona'])) {
            // Crear una instancia de PersonaDTO
            $personaDTO = new PersonaDTO(
                $data['id'],
                $data['ci'],
                $data['nombre_persona'],
                $data['apellido_persona'],
                $data['clave_persona'],
                $data['correo_persona'],
                $data['bloqueado'],
                $data['numer_intentos']
            );
            
            // Llamar al servicio para crear la persona
            if ($personaService->createPersona($personaDTO)) {
                http_response_code(201);
                echo json_encode(['message' => 'Persona creada']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Error al crear la persona']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Datos incompletos']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id'], $data['ci'], $data['nombre_persona'], $data['apellido_persona'], $data['clave_persona'], $data['correo_persona'])) {
            // Crear una instancia de PersonaDTO
            $personaDTO = new PersonaDTO(
                $data['id'],
                $data['ci'],
                $data['nombre_persona'],
                $data['apellido_persona'],
                $data['clave_persona'],
                $data['correo_persona'],
                $data['bloqueado'],
                $data['numer_intentos']
            );
            
            // Llamar al servicio para crear la persona
            if ($personaService->updatePersona($personaDTO)) {
                http_response_code(201);
                echo json_encode(['message' => 'Persona actualizada']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Error al actualizar la persona']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Datos incompletos']);
        }
        break;

    case 'DELETE':
        if (isset($requestUri[2])) {
            $ci_persona = $requestUri[2];
            if ($personaService->deletePersona($ci_persona)) {
                http_response_code(204);
                echo json_encode(['message' => 'Persona eliminada']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Persona no encontrada']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'CI de persona no proporcionado']);
        }
        break;

    case 'OPTIONS':
        // Manejar la solicitud OPTIONS para CORS
        http_response_code(200);
        break;

    default:
        http_response_code(405); // Method Not Allowed
        echo json_encode(['message' => 'Método no permitido']);
        break;
}