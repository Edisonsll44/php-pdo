<?php

include_once "../infraestructure/repositories/contactRepository.php";
include_once "../entities/contact.php";
// Servicio para el mapeo
class ContactoService {
    private $contactRepository;

    public function setcontactoRepository(ContactoRepository $contactRepository) {
        $this->contactRepository = $contactRepository; 
    }

    public function createContacto(ContactoDTO $dto): Contacto {
        // Mapeo del DTO a la entidad
        $contacto = new Contacto(
            $dto->apellido_contacto,
            $dto->email_contacto,
            $dto->nombre_contacto,
            $dto->telefono_contacto,
            $dto->id_persona
        );

        // Guardar la entidad en la base de datos usando el repositorio
        $this->contactRepository->create($contacto);

        return $contacto; // Retorna la entidad creada
    }

    public function updateContacto(ContactoDTO $dto): Contacto {
        $contactosExistente = $this->contactRepository->getOne($dto->id);

        if (!$contactosExistente) {
            echo "No se puede actualizar. Contacto no encontrado.\n";
            return null;
        }
            $contacto = new Contacto(
                $dto->apellido_contacto,
                $dto->email_contacto,
                $dto->nombre_contacto,
                $dto->telefono_contacto,
                $dto->id_persona
            );
             // Actualizar la entidad en la base de datos usando el repositorio
             $this->contactRepository->update($contacto, $contactosExistente->id);
             return $contacto;
    }

    public function deleteContacto($id): bool {

        // Eliminar la contactos usando el repositorio
       return $this->contactRepository->delete($id);
    }

    public function getContacto($id) {
       // Obtener la contactos usando el repositorio
        $contactos = $this->contactRepository->getOne($id);
        return $contactos;
    }

    public function getContactos() {
        // Obtener la contactos usando el repositorio
        return $this->contactRepository->getAll();
    }
}
?>