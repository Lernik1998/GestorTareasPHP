<?php

// Requiero archivo Usuario y ContrasenaInvalida

require "./Usuario.php";
require "./ContrasenaInvalidaException.php";

session_start();

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
                header("Location: ./gestorTareas.php");
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
                    header("Location: login.php");
                    exit();
                }
            } else {
                $_SESSION["error"] = "Falta algún dato!";
            }
        }
    }
}


// Obtengo el error 
$error = $_SESSION["error"] ?? "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login gestor de tareas</title>
    <link rel="stylesheet" href="./Assets/CSS/general.css">
    <link rel="stylesheet" href="./Assets/CSS/login.css">
</head>

<body>
<div class="container">
        <h1>Login</h1>

        <div class="login-form">
            <form action="" method="post">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
                <br><br>
                <label for="contrasenya">Contraseña:</label>
                <input type="password" name="contrasenya" id="contrasenya" required>
                <br><br>
                <button type="submit" name="hacerLogin">Acceder</button>
                <br><br>
            </form>

            <form action="cerrarSesion.php" method="post">
                <button type="submit" name="cerrarSesion">Cerrar sesión</button>
            </form>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
                <?php unset($_SESSION["error"]); // Limpiar mensaje después de mostrar ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>