<?php

include_once "../infraestructure/repositories/personRepository.php";
include_once "../entities/person.php";
// Servicio para el mapeo
class PersonaService {
    private $personaRepository;

    public function setPersonaRepository(PersonaRepository $personaRepository) {
        $this->personaRepository = $personaRepository; 
    }

    public function createPersona(PersonaDTO $dto): Persona {
        // Mapeo del DTO a la entidad
        $persona = new Persona(
            $dto->ci,
            $dto->nombre_persona,
            $dto->apellido_persona,
            $dto->clave_persona,
            $dto->correo_persona,
            $dto->bloqueado,
            $dto->numero_intentos
        );

        // Guardar la entidad en la base de datos usando el repositorio
        $this->personaRepository->create($persona);

        return $persona; // Retorna la entidad creada
    }

    public function updatePersona(PersonaDTO $dto): Persona {
        $personaExistente = $this->personaRepository->getOne($dto->ci);

        if (!$personaExistente) {
            echo "No se puede actualizar. Contacto no encontrado.\n";
            return null;
        }
        $persona = new Persona(
            $dto->ci,
            $dto->nombre_persona,
            $dto->apellido_persona,
            $dto->clave_persona,
            $dto->correo_persona,
            $dto->bloqueado,
            $dto->numero_intentos
        );
             // Actualizar la entidad en la base de datos usando el repositorio
             $this->personaRepository->update($persona, $personaExistente->id);
             return $persona;
    }

    public function deletePersona($ci_persona): bool {

        // Eliminar la persona usando el repositorio
       return $this->personaRepository->delete($ci_persona);
    }

    public function getPersona($ci_persona) {
       // Obtener la persona usando el repositorio
        $persona = $this->personaRepository->getOne($ci_persona);
        return $persona;
    }

    public function getPersonas() {
        // Obtener la persona usando el repositorio
        return $this->personaRepository->getAll();
    }
}
?>