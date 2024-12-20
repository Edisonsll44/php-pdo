<?php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once '../infraestructure/conn/conection.php';
require_once '../infraestructure/repositories/contactRepository.php';
require_once '../logic/contactService.php';

$conexion = new Conexion();
$pdo = $conexion->getConnection();
$repository = new ContactoRepository($pdo);

$contactoService = new ContactoService();
$contactoService->setContactoRepository($repository);

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Manejo de las solicitudes
switch ($requestMethod) {
    case 'GET':
        if (isset($requestUri[2])) {
            
            // Obtener una Contacto por CI
            $ci_Contacto = $requestUri[2];
            $contacto = $contactoService->getContacto($ci_Contacto);
            if ($contacto) {
                echo json_encode($contacto);
            } else {

                http_response_code(404);
                echo json_encode(['message' => 'Contacto no encontrada']);
            }
        } else {
            // Obtener todas las Contactos
            $contactos = $contactoService->getContactos();
            echo json_encode($contactos);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

         // Verifica que los datos necesarios estén presentes
        if (isset($data['id'], $data['nombre_contacto'], $data['apellido_contacto'], $data['email_contacto'], $data['telefono_contacto'], $data['id_persona'],$data['cedula_persona'])) {
            // Crear una instancia de ContactoDTO
            $contactoDTO = new ContactoDTO(
                $data['id'],
                $data['apellido_contacto'],
                $data['email_contacto'],
                $data['nombre_contacto'],
                $data['telefono_contacto'],
                $data['id_persona'],
                $data['cedula_persona'],
            );
            
            // Llamar al servicio para crear la Contacto
            if ($contactoService->createContacto($contactoDTO)) {
                http_response_code(201);
                echo json_encode(['message' => 'Contacto creado']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Error al crear el contacto']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Datos incompletos']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id'], $data['nombre_contacto'], $data['apellido_contacto'], $data['email_contacto'], $data['telefono_contacto'], $data['id_persona'],$data['cedula_persona'])) {
            // Crear una instancia de ContactoDTO
           $contactoDTO = new ContactoDTO(
                $data['id'],
                $data['apellido_contacto'],
                $data['email_contacto'],
                $data['nombre_contacto'],
                $data['telefono_contacto'],
                $data['id_persona'],
                $data['cedula_persona'],
            );
            
            // Llamar al servicio para crear la Contacto
            if ($contactoService->updateContacto($contactoDTO)) {
                http_response_code(201);
                echo json_encode(['message' => 'Contacto actualizado']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Error al actualizar el contacto']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Datos incompletos']);
        }
        break;

    case 'DELETE':
        if (isset($requestUri[2])) {
            $id = $requestUri[2];
            if ($contactoService->deleteContacto($id)) {
                http_response_code(204);
                echo json_encode(['message' => 'Contacto eliminada']);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Contacto no encontrada']);
            }
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Id de contacto no proporcionado']);
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