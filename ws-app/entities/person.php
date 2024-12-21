<?php

// Definición de la entidad
class Persona {
    private $ci_persona;
    private $nom_persona;
    private $ape_persona;
    private $clave_persona;
    private $correo_persona;
    private $bloqueado;
    private $intentos_fallidos;
    

    public function __construct( $ci_persona, $nom_persona, $ape_persona, $clave_persona, $correo_persona, $bloqueado, $intentos_fallidos) {
        $this->ci_persona = $ci_persona;
        $this->nom_persona = $nom_persona;
        $this->ape_persona = $ape_persona;
        $this->clave_persona = $clave_persona;
        $this->correo_persona = $correo_persona;
        $this->bloqueado = $bloqueado;
        $this->intentos_fallidos = $intentos_fallidos;
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

    public function getIntentosFallidos() {
        return $this->intentos_fallidos;
    }

    public function getBloqueado() {
        return $this->bloqueado;
    }

    public function getCorreoPersona() {
        return $this->correo_persona;
    }

    public function setIntentosFallidos($intentos) {
        $this->intentos_fallidos = $intentos;
    }

    public function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }
}

?>