<?php
include_once "../logic/dto/contactDto.php";
class ContactoRepository {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create(Contacto $contacto) {
        $sql = "INSERT INTO contacto (ape_contacto, nom_contacto, email_contacto, telefono_contacto,persona_cod_persona) 
                VALUES (:ape_contacto, :nom_contacto, :email_contacto, :telefono_contacto, :persona_cod_persona)";

        $stmt = $this->pdo->prepare($sql);
        
        // Almacenar los valores en variables
        $ape_contacto = $contacto->getApellidoContacto();
        $nom_contacto = $contacto->getNombreContacto();
        $email_contacto = $contacto->getApellidoContacto();
        $telefono_contacto = $contacto->getTelefonoContacto();
        $persona_cod_persona = $contacto->getCodigoPersona();

        // Ahora pasar las variables a bindParam
        $stmt->bindParam(':ape_contacto', $ape_contacto);
        $stmt->bindParam(':nom_contacto', $nom_contacto);
        $stmt->bindParam(':email_contacto', $email_contacto);
        $stmt->bindParam(':telefono_contacto', $telefono_contacto);
        $stmt->bindParam(':persona_cod_persona', $persona_cod_persona);

        $stmt->execute();
    }

    public function update(Contacto $contacto, $id) {
        $sql = "UPDATE contacto SET 
                ape_contacto = :ape_contacto,
                nom_contacto = :nom_contacto, 
                email_contacto = :email_contacto, 
                telefono_contacto = :telefono_contacto, 
                persona_cod_persona = :persona_cod_persona 
                WHERE cod_contacto = :id";

        $stmt = $this->pdo->prepare($sql);

         // Almacenar los valores en variables
         $ape_contacto = $contacto->getApellidoContacto();
         $nom_contacto = $contacto->getNombreContacto();
         $email_contacto = $contacto->getApellidoContacto();
         $telefono_contacto = $contacto->getTelefonoContacto();
         $persona_cod_persona = $contacto->getCodigoPersona();
 
         // Ahora pasar las variables a bindParam
         $stmt->bindParam(':ape_contacto', $ape_contacto);
         $stmt->bindParam(':nom_contacto', $nom_contacto);
         $stmt->bindParam(':email_contacto', $email_contacto);
         $stmt->bindParam(':telefono_contacto', $telefono_contacto);
         $stmt->bindParam(':persona_cod_persona', $persona_cod_persona);
         $stmt->bindParam(':id', $id);

        $stmt->execute();
    }

    public function delete($cod_contacto): bool {
        // Verificar si la persona existe antes de intentar eliminar
        $sql = "SELECT COUNT(*) FROM contacto WHERE cod_contacto = :cod_contacto";
        $stm= $this->pdo->prepare($sql);
        $stm->bindParam(':cod_contacto', $cod_contacto);
        $stm->execute();
        $exists = $stm->fetchColumn();
    
        if ($exists == 0) {
            echo "No se puede eliminar,el contacto no existe.\n";
            return false;
        }
    
        $sql = "DELETE FROM contacto WHERE cod_contacto = :cod_contacto";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':cod_contacto', $cod_contacto);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error en la base de datos: " . $e->getMessage() . "\n";
        }
        return false;
    }

    public function getOne($cod_contacto): ContactoDTO|null {
        
        $sql = "SELECT  c.cod_contacto, c.ape_contacto, c.email_contacto, c.nom_contacto, c.telefono_contacto, c.persona_cod_persona, p.ci_persona FROM contacto c
                inner join persona p on c.persona_cod_persona = p.cod_persona
                where cod_contacto = :cod_contacto";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':cod_contacto', $cod_contacto);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result) {
            return new ContactoDTO(
                $result['cod_contacto'],
                $result['ape_contacto'],
                $result['email_contacto'],
                $result['nom_contacto'],
                $result['telefono_contacto'],
                $result['persona_cod_persona'],
                $result['ci_persona']
            );
        } else {
            echo "Persona no encontrada.\n";
            return null;
        }
    }

    public function getAll() {
        $sql = "SELECT  c.cod_contacto, c.ape_contacto, c.email_contacto, c.nom_contacto, c.telefono_contacto, c.persona_cod_persona, CONCAT(p.nom_persona,' ',p.ape_persona) as ci_persona  FROM contacto c
                inner join persona p on c.persona_cod_persona = p.cod_persona";
        $stmt = $this->pdo->query($sql);
        $personas = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $personas[] = new ContactoDto(
                $row['cod_contacto'],
                $row['ape_contacto'],
                $row['email_contacto'],
                $row['nom_contacto'],
                $row['telefono_contacto'],
                $row['persona_cod_persona'],
                $row['ci_persona']
            );
        }

        return $personas;
    }
}
?>