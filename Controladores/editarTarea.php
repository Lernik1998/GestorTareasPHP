<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Incluyo los modelos
require "../Clases/Tarea.php";
require "../Clases/ManagerTareas.php";

// Inicio la sesión
session_start();

// Verificar que se envió un índice 
if (!isset($_POST["indice"])) {
    header("Location: ./gestorTareas.php");
    exit();
}

// Almaceno un indice
$indice = $_POST["indice"];

// Instancia de ManagerTareas para obtener el array de tareas con el metodo obtenerTareas
$manager = new ManagerTareas();
$arrayTareas = $manager->obtenerTareas();

// Verifica si existe la tarea en ese índice, si no vuelvo al gestor
if (!isset($arrayTareas[$indice])) {
    header("Location: ./gestorTareas.php");
    exit();
}
// Si existe, lo almaceno
$tarea = $arrayTareas[$indice];

require "../Vistas/view.editarTarea.php";

// Si del formulario recibo post y se presiona guardarCambios
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Almaceno los valores
    // Almaceno los valores de manera segura
    $nombre = isset($_POST["tarea"]) ? $_POST["tarea"] : '';
    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : '';
    $prioridad = isset($_POST["prioridad"]) ? $_POST["prioridad"] : '';
    $fechaLim = isset($_POST["fechaLim"]) ? $_POST["fechaLim"] : '';


    if (isset($_POST["guardarCambios"])) {
        if (!empty($nombre) && !empty($descripcion)) {
            // Crear una nueva tarea con los datos actualizados
            $tareaEditada = new Tarea($nombre, $descripcion, $prioridad, $fechaLim);
            // Obtengo el indice y la nueva tarea con los datos obtenidos para hacer la llamada al método
            $manager->editarTarea($indice, $tareaEditada);

            // Redirigir al gestor de tareas después de la edición
            header("Location: ./gestorTareas.php");
            exit();
        } else {
            // Array de errores
            $_SESSION["error"] = "Faltan datos para editar la tarea";
        }

    } elseif (isset($_POST["borrarTarea"])) {

        $manager->eliminarTarea($indice);
        // Redirigir al gestor de tareas después de la edición
        header("Location: ./gestorTareas.php");
        exit();

    }
}

?>