<?php

// Obtengo el error, de la sesión
$error = $_SESSION["error"] ?? ""; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login gestor de tareas</title>
    <link rel="stylesheet" href="../Assets/CSS/general.css">
    <link rel="stylesheet" href="../Assets/CSS/login.css">
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