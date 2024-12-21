<?php
include_once "../logic/dto/personDto.php";
class PersonaRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(Persona $persona) {
        $sql = "INSERT INTO persona (ci_persona, nom_persona, ape_persona, clave_persona, correo_persona) 
                VALUES (:ci_persona, :nom_persona, :ape_persona, :clave_persona, :correo_persona)";

        $stmt = $this->pdo->prepare($sql);
        
        // Almacenar los valores en variables
        $ci_persona = $persona->getCiPersona();
        $nom_persona = $persona->getNomPersona();
        $ape_persona = $persona->getApePersona();
        $clave_persona = $persona->getClavePersona();
        $correo_persona = $persona->getCorreoPersona();

        // Ahora pasar las variables a bindParam
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':nom_persona', $nom_persona);
        $stmt->bindParam(':ape_persona', $ape_persona);
        $stmt->bindParam(':clave_persona', $clave_persona);
        $stmt->bindParam(':correo_persona', $correo_persona);

        if ($stmt->execute()) {
            echo "Persona guardada exitosamente.\n";
        } else {
            echo "Error al guardar la persona.\n";
        }
    }

    public function update(Persona $persona, $id) {
        $sql = "UPDATE persona SET 
                ci_persona = :ci_persona,
                nom_persona = :nom_persona, 
                ape_persona = :ape_persona, 
                clave_persona = :clave_persona, 
                correo_persona = :correo_persona 
                WHERE cod_persona = :id";

        $stmt = $this->pdo->prepare($sql);

         // Almacenar los valores en variables
        $ci_persona = $persona->getCiPersona();
        $nom_persona = $persona->getNomPersona();
        $ape_persona = $persona->getApePersona();
        $clave_persona = $persona->getClavePersona();
        $correo_persona = $persona->getCorreoPersona();

        // Ahora pasar las variables a bindParam
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':nom_persona', $nom_persona);
        $stmt->bindParam(':ape_persona', $ape_persona);
        $stmt->bindParam(':clave_persona', $clave_persona);
        $stmt->bindParam(':correo_persona', $correo_persona);
        $stmt->bindParam(':id', $id);


        if ($stmt->execute()) {
            echo "Persona actualizada exitosamente.\n";
        } else {
            echo "Error al actualizar la persona.\n";
        }
    }

    public function delete($ci_persona): bool {
        // Verificar si la persona existe antes de intentar eliminar
        $sql = "SELECT COUNT(*) FROM persona WHERE ci_persona = :ci_persona";
        $stm= $this->pdo->prepare($sql);
        $stm->bindParam(':ci_persona', $ci_persona);
        $stm->execute();
        $exists = $stm->fetchColumn();
    
        if ($exists == 0) {
            echo "No se puede eliminar, la persona no existe.\n";
            return false;
        }
    
        $sql = "DELETE FROM persona WHERE ci_persona = :ci_persona";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':ci_persona', $ci_persona);
    
            if ($stmt->execute()) {
                echo "Persona eliminada exitosamente.\n";
            } else {
                echo "Error al eliminar la persona.\n";
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage() . "\n";
        }
        return false;
    }

    public function getOne($ci_persona): PersonaDTO|null {
        
        $sql = "SELECT * FROM persona WHERE ci_persona = :ci_persona";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new PersonaDTO(
                $result['cod_persona'],
                $result['ci_persona'],
                $result['nom_persona'],
                $result['ape_persona'],
                $result['clave_persona'],
                $result['correo_persona'],
                $result['bloqueado'],
                $result['intentos_fallidos']
            );
        } else {
            echo "Persona no encontrada.\n";
            return null;
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM persona";
        $stmt = $this->pdo->query($sql);
        $personas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personas[] = new PersonaDTO(
                $row['cod_persona'],
                $row['ci_persona'],
                $row['nom_persona'],
                $row['ape_persona'],
                $row['clave_persona'],
                $row['correo_persona'],
                $row['bloqueado'],
                $row['intentos_fallidos']
            );
        }

        return $personas;
    }

    public function getUserAutenticate($ci_persona, $clave_persona): PersonaDTO|null {
        
        $sql = "SELECT * FROM persona WHERE ci_persona = :ci_persona and clave_persona = :clave_persona ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->bindParam(':clave_persona', $clave_persona);

        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new PersonaDTO(
                $result['cod_persona'],
                $result['ci_persona'],
                $result['nom_persona'],
                $result['ape_persona'],
                $result['clave_persona'],
                $result['correo_persona'],
                $result['bloqueado'],
                $result['intentos_fallidos']
            );
        } 
        return null;
    }

    public function updateIntentsAndBlockPerson(PersonaDTO $persona) {
        $sql = "UPDATE persona SET 
                    intentos_fallidos = :intentos_fallidos,
                    bloqueado = :bloqueado
                WHERE ci_persona = :ci_persona";
    
        $stmt = $this->pdo->prepare($sql);
        // Almacenar los valores en variables
        $intentos_fallidos = $persona->getIntentosFallidos();
        $bloqueado = $persona->getBloqueado();
        $ci_persona = $persona->getCiPersona();
    
        // Pasar las variables a bindParam
        $stmt->bindParam(':intentos_fallidos', $intentos_fallidos);
        $stmt->bindParam(':bloqueado', $bloqueado, PDO::PARAM_BOOL);
        $stmt->bindParam(':ci_persona', $ci_persona);
        $stmt->execute();
    }
}
?>