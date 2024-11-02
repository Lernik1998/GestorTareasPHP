<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Incluyo los modelos
require "../Clases/Tarea.php";
require "../Clases/ManagerTareas.php";

// Inicio la sesion
session_start();


// Si no hay una sesión activa
if (!isset($_SESSION["usuario"])) {
    header("Location: ./login.php");
    exit();
}


// Deserializamos el objeto usuario
$usuario = unserialize($_SESSION["usuario"]);

// Manager
$manager = new ManagerTareas();

// Verificamos el POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $tarea = $_POST["tarea"];
    $descrip = $_POST["descripcion"];
    $prioridad = $_POST["prioridad"];
    $fechaLim = $_POST["fechaLim"];

    if (!empty($tarea) && !empty($descrip)) {

        if (isset($_POST["crearTarea"])) {
            $tarea = new Tarea($tarea, $descrip, $prioridad, $fechaLim);
            $manager->crearTarea($tarea);
        }

    } else {
        $_SESSION["error"] = "Faltan datos para crear una tarea";
        header("Location: ./gestorTareas.php");
        exit();
    }
}

// Requiero la vista
require "../Vistas/view.gestorTareas.php";
