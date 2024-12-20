<?php

class ContactoDTO {
    public $id;
    public $apellido_contacto;
    public $email_contacto;
    public $nombre_contacto;
    public $telefono_contacto;
    public $id_persona;
    public $cedula_persona;

    public function __construct($id, $apellido_contacto,$email_contacto, $nombre_contacto, $telefono_contacto, $id_persona, $cedula_persona) {
        $this->id=$id;
        $this->apellido_contacto=$apellido_contacto;
        $this->email_contacto = $email_contacto;
        $this->nombre_contacto = $nombre_contacto;
        $this->telefono_contacto = $telefono_contacto;
        $this->id_persona = $id_persona;
        $this->cedula_persona=$cedula_persona;
    }
}
?>