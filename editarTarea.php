<?php

// Incluyo los modelos
require "Tarea.php";
require "ManagerTareas.php";

// Inicio la sesión
session_start();

// Verificar que se envió un índice 
if (!isset($_POST["indice"])) {
    header("Location: gestorTareas.php");
    exit();
}

// Almaceno un indice
$indice = $_POST["indice"];

// Instancia de ManagerTareas para obtener el array de tareas con el metodo obtenerTareas
$manager = new ManagerTareas();
$arrayTareas = $manager->obtenerTareas();

// Verifica si existe la tarea en ese índice, si no vuelvo al gestor
if (!isset($arrayTareas[$indice])) {
    header("Location: gestorTareas.php");
    exit();
}
// Si existe, lo almaceno
$tarea = $arrayTareas[$indice];


// Si del formulario recibo post y se presiona guardarCambios
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Almaceno los valores
    $nombre = $_POST["tarea"];
    $descripcion = $_POST["descripcion"];
    $prioridad = $_POST["prioridad"];
    $fechaLim = $_POST["fechaLim"];

    if (isset($_POST["guardarCambios"])) {
        if (!empty($nombre) && !empty($descripcion)) {
            // Crear una nueva tarea con los datos actualizados
            $tareaEditada = new Tarea($nombre, $descripcion, $prioridad, $fechaLim);
            // Obtengo el indice y la nueva tarea con los datos obtenidos para hacer la llamada al método
            $manager->editarTarea($indice, $tareaEditada);

            // Redirigir al gestor de tareas después de la edición
            header("Location: gestorTareas.php");
            exit();
        } else {
            // Array de errores
            $_SESSION["error"] = "Faltan datos para editar la tarea";
        }

    } elseif (isset($_POST["borrarTarea"])) {

        $manager->eliminarTarea($indice);
        // Redirigir al gestor de tareas después de la edición
        header("Location: gestorTareas.php");
        exit();

    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="./Assets/CSS/general.css">
    <link rel="stylesheet" href="./Assets/CSS/gestorTareas.css">
</head>

<body>
    <div class="container">
        <h1>Editar Tarea</h1>

        <form action="" method="post" class="edit-task-form">
            <input type="hidden" name="indice" value="<?php echo $indice; ?>">

            <div class="form-group">
                <label for="tarea">Tarea</label>
                <input type="text" name="tarea" id="tarea" value="<?php echo htmlspecialchars($tarea->getNombre()); ?>">
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea name="descripcion"
                    id="descripcion"><?php echo htmlspecialchars($tarea->getDescripcion()); ?></textarea>
            </div>

            <div class="form-group">
                <label for="prioridad">Prioridad</label>
                <select name="prioridad" id="prioridad">
                    <option value="baja" <?php echo $tarea->getPrioridad() === "baja" ? "selected" : ""; ?>>Baja</option>
                    <option value="media" <?php echo $tarea->getPrioridad() === "media" ? "selected" : ""; ?>>Media
                    </option>
                    <option value="alta" <?php echo $tarea->getPrioridad() === "alta" ? "selected" : ""; ?>>Alta</option>
                </select>
            </div>

            <div class="form-group">
                <label for="fechaLim">Fecha límite</label>
                <input type="date" name="fechaLim" id="fechaLim"
                    value="<?php echo htmlspecialchars($tarea->getFechaLim()); ?>">
            </div>

            <div class="form-buttons">
                <button type="submit" name="guardarCambios">Guardar cambios</button>
                <button type="submit" name="borrarTarea">Borrar tarea</button>
            </div>
        </form>

        <br>
        <a href="gestorTareas.php">Cancelar y volver</a>

        <?php if (isset($_SESSION["error"])): ?>
            <div class="error-message">
                <p style="color: red;"><?php echo $_SESSION["error"];
                unset($_SESSION["error"]); ?></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>