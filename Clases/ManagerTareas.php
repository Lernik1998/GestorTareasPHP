<?php

/* Con los métodos CRUD de las tareas:
Create
Read
Update
Delete 

Debe ofrecer la funcionalidad de agregar, editar, visualizar y eliminar tareas.
*/
class ManagerTareas
{
    // Constructor para inicializar el arreglo de tareas desde la sesión
    public function __construct()
    {
        // Iniciar el arreglo de tareas desde la sesión si no existe
        if (!isset($_SESSION['tareas'])) {
            $_SESSION['tareas'] = [];
        }
    }

    // Crear una nueva tarea
    function crearTarea($tarea)
    {
        // Verificar si la tarea ya existe para evitar duplicados
        foreach ($_SESSION['tareas'] as $tareaExistente) {
            if ($tareaExistente->getNombre() === $tarea->getNombre()) {
                // No agregamos si ya existe
                return;
            }
        }

        // Añadir la nueva tarea al arreglo en sesión
        $_SESSION['tareas'][] = $tarea;
    }

    // Editar una tarea
    function editarTarea($indiceTarea, $nuevaTarea)
    {
        // Verificar que el índice es válido
        if (isset($_SESSION['tareas'][$indiceTarea])) {
            $_SESSION['tareas'][$indiceTarea] = $nuevaTarea;
        }
    }

    // Obtener todas las tareas
    function obtenerTareas()
    {
        return $_SESSION['tareas'];
    }

    // Eliminar una tarea
    function eliminarTarea($indiceTarea)
    {
        // Verificar que el índice es válido
        if (isset($_SESSION['tareas'][$indiceTarea])) {
            unset($_SESSION['tareas'][$indiceTarea]);
            // Reindexar el array para evitar huecos
            $_SESSION['tareas'] = array_values($_SESSION['tareas']);
        }
    }
}



