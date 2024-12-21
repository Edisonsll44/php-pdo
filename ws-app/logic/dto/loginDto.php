<?php

// Definición del DTO
class LoginDTO {
    public $usuario;
    public $clave;

    public function __construct($usuario, $clave) {
        $this->usuario=$usuario;
        $this->clave = $clave;
    }
}

?>