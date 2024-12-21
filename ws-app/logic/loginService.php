<?php

class LoginService {

private $personaRepository;

public function setLoginRepository(PersonaRepository $personaRepository) {
    $this->personaRepository = $personaRepository; 
}
// Función para iniciar sesión
    public function login(LoginDTO $dto) {
        // Obtener las credenciales del DTO
        $ci_persona = $dto->usuario;
        $clave_persona = $dto->clave;

        
        // Buscar el usuario en la base de datos
        $personaDto = $this->personaRepository->getOne($ci_persona);
        // Verificar si el usuario existe
        if (!$personaDto) {
            
            return ['success' => false, 'message' => 'Usuario no encontrado.'];
        }

        // Verificar si el usuario está bloqueado
        if ($personaDto->isBloqueado()) {
            return ['success' => false, 'message' => 'Cuenta bloqueada. Intente más tarde.'];
        }

        // Verificar la contraseña
        if ($clave_persona == $personaDto->getClavePersona()) {
            // Reiniciar intentos fallidos
            $personaDto->setIntentosFallidos(0);
            $personaDto->setBloqueado(false);
            $this->personaRepository->updateIntentsAndBlockPerson($personaDto);
            return ['success' => true, 'message' => 'Inicio de sesión exitoso.'];
        } else {
            // Incrementar intentos fallidos
            $intentos_fallidos = $personaDto->getIntentosFallidos() + 1;
            $personaDto->setIntentosFallidos($intentos_fallidos);

            // Bloquear cuenta si se alcanzan 3 intentos fallidos
            if ($intentos_fallidos >= 3) {
                $personaDto->setBloqueado(true);
            }
            $this->personaRepository->updateIntentsAndBlockPerson($personaDto);
            return ['success' => false, 'message' => 'Contraseña incorrecta. Intentos restantes: ' . (3 - $intentos_fallidos)];
        }
    }
}
?>