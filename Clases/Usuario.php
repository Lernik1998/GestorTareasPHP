<?php


// Manejará el login y la sesión de usuario
class Usuario
{
    private $nombre;
    private $contra;

    public function __construct($nombre, $contra)
    {

        $this->nombre = $nombre;
        $this->setContra($contra);
    }


    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getContra()
    {
        return $this->contra;
    }

    public function setContra($contra)
    {
        $this->contra = $contra;
    }


    // Lo usamos desde el set, que hace la validacion
    public static function validarClave($contra)
    {
        if (strlen($contra) < 5) {
            throw new ContrasenaInvalidaException("La contraseña debe tener al menos 5 caracteres.");
        }
        if (!preg_match('/[A-Z]/', $contra)) {
            throw new ContrasenaInvalidaException("La contraseña debe contener al menos una letra mayúscula.");
        }
        if (!preg_match('/[0-9]/', $contra)) {
            throw new ContrasenaInvalidaException("La contraseña debe contener al menos un número.");
        }
    }
}
