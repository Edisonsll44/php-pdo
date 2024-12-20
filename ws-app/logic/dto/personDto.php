<?php

// Definición del DTO
class PersonaDTO {
    public $id;
    public $ci;
    public $nombre_persona;
    public $apellido_persona;
    public $clave_persona;
    public $correo_persona;

    public function __construct($id,$ci, $nombre_persona, $apellido_persona, $clave_persona, $correo_persona) {
        $this->id=$id;
        $this->ci = $ci;
        $this->nombre_persona = $nombre_persona;
        $this->apellido_persona = $apellido_persona;
        $this->clave_persona = $clave_persona;
        $this->correo_persona = $correo_persona;
    }
}

?>