<?php

// Definición de la entidad
class Persona {
    private $ci_persona;
    private $nom_persona;
    private $ape_persona;
    private $clave_persona;
    private $correo_persona;

    public function __construct( $ci_persona, $nom_persona, $ape_persona, $clave_persona, $correo_persona) {
        $this->ci_persona = $ci_persona;
        $this->nom_persona = $nom_persona;
        $this->ape_persona = $ape_persona;
        $this->clave_persona = $clave_persona;
        $this->correo_persona = $correo_persona;
    }

    // Métodos para acceder a los atributos (getters)
    public function getCiPersona() {
        return $this->ci_persona;
    }

    public function getNomPersona() {
        return $this->nom_persona;
    }

    public function getApePersona() {
        return $this->ape_persona;
    }

    public function getClavePersona() {
        return $this->clave_persona;
    }

    public function getCorreoPersona() {
        return $this->correo_persona;
    }
}

?>