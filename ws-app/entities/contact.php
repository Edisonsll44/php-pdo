<?php
class Contacto  {
    private $ape_contacto;
    private $email_contacto;
    private $nom_contacto;
    private $telefono_contacto;
    private $persona_cod_persona;

    public function __construct($ape_contacto, $email_contacto, $nom_contacto,$telefono_contacto, $persona_cod_persona){
        $this->ape_contacto= $ape_contacto;
        $this->email_contacto= $email_contacto;
        $this->nom_contacto= $nom_contacto;
        $this->telefono_contacto= $telefono_contacto;
        $this->persona_cod_persona= $persona_cod_persona;
    }

    public function getApellidoContacto(){
        return $this->ape_contacto;
    }

    public function getEmailContacto(){
        return $this->email_contacto;
    }

    public function getNombreContacto(){
        return $this->nom_contacto;
    }

    public function getTelefonoContacto(){
        return $this->telefono_contacto;
    }

    public function getCodigoPersona(){
        return $this->persona_cod_persona;
    }
}
?>