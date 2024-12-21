<?php

// Definición del DTO
class PersonaDTO {
    public $id;
    public $ci;
    public $nombre_persona;
    public $apellido_persona;
    public $clave_persona;
    public $correo_persona;
    public $bloqueado;
    public $numero_intentos;

    public function __construct($id,$ci, $nombre_persona, $apellido_persona, $clave_persona, $correo_persona,$bloqueado, $numero_intentos) {
        $this->id=$id;
        $this->ci = $ci;
        $this->nombre_persona = $nombre_persona;
        $this->apellido_persona = $apellido_persona;
        $this->clave_persona = $clave_persona;
        $this->correo_persona = $correo_persona;
        $this->bloqueado= $bloqueado;
        $this->numero_intentos=$numero_intentos;
    }

    public function getCiPersona() {
        return $this->ci;
    }

    public function getNomPersona() {
        return $this->nombre_persona;
    }

    public function getApePersona() {
        return $this->apellido_persona;
    }

    public function getClavePersona() {
        return $this->clave_persona;
    }

    public function getCorreoPersona() {
        return $this->correo_persona;
    }

    public function isBloqueado() {
        return $this->bloqueado;
    }

    public function getIntentosFallidos() {
        return $this->numero_intentos;
    }

    public function setIntentosFallidos($intentos) {
        $this->numero_intentos = $intentos;
    }

    public function setBloqueado($bloqueado) {
        $this->bloqueado = $bloqueado;
    }

    public function getBloqueado() {
        return $this->bloqueado;
    }
}

?>