<?php
// Define una excepción PERSONALIZADA para manejar errores de contraseña
class ContrasenaInvalidaException extends Exception
{
    public function __construct($mensaje)
    {
        parent::__construct($mensaje);
    }
}
