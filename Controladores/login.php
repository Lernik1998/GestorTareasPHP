<?php

// Requiero clases Usuario y ContrasenaInvalida

require "../Clases/Usuario.php";
require "../Clases/ContrasenaInvalidaException.php";


session_start();

// Requiero la vista del login
require "../Vistas/view.login.php";

// Si hay un post con los datos
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si los datos están establecidos
    if (isset($_POST["nombre"]) && isset($_POST["contrasenya"])) {
        // Guardamos los datos
        $nombre = $_POST["nombre"];
        $contra = $_POST["contrasenya"];

        // Si no hay un usuario en sesion 
        if (!isset($_SESSION["nombre"])) {
            // Validamos y cremos en usuario de sesion
            try {
                // Verifico
                Usuario::validarClave($contra);
                // Creo usuario
                $usuario = new Usuario($nombre, $contra);

                // Guardo en las variables de sesion los datos
                $_SESSION["nombre"] = $nombre;
                $_SESSION["contrasenya"] = $contra;

                // Guardo serializado en la variable de sesion el usuario
                $_SESSION["usuario"] = serialize($usuario);

                // Redirección al gestor de tareas
                header("Location: ../Controladores/gestorTareas.php");
                exit();

            } catch (ContrasenaInvalidaException $e) {
                // Guardo en mensaje de error en variable de sesion
                $_SESSION["error"] = $e->getMessage();

                // Redirecciono a la misma pagina
                header("Location: ./login.php");
                exit();
            }
        } else {
            // Si hay sesion, verifico datos
            if (isset($_POST["nombre"]) && isset($_POST["contrasenya"])) {
                if ($_POST["nombre"] == $_SESSION["nombre"] && $_POST["contrasenya"] == $_SESSION["contrasenya"]) {
                    header("Location: ./gestorTareas.php");
                    exit();
                } else {
                    $_SESSION["error"] = "Datos incorrectos!";
                    header("Location: ./login.php");
                    exit();
                }
            } else {
                $_SESSION["error"] = "Falta algún dato!";
            }
        }
    }
}