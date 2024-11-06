<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index( Router $router ) {
        session_start();
        
        isAdmin();

        // Obtener la fecha actual o la fecha proporcionada por GET
        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        // Validar que la fecha sea correcta (año, mes, día)
        if( !checkdate( $fechas[1], $fechas[2], $fechas[0]) ) { // Asegúrate de que los índices están bien
            header('Location: /404');
            exit(); // Es importante usar exit() después de un redireccionamiento para evitar seguir ejecutando el script.
        }

        // Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT(usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= "usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio ";
        $consulta .= "FROM citas ";
        $consulta .= "LEFT OUTER JOIN usuarios ON citas.usuarioId = usuarios.id ";
        $consulta .= "LEFT OUTER JOIN citasServicios ON citas.id = citasServicios.citaId ";
        $consulta .= "LEFT OUTER JOIN servicios ON servicios.id = citasServicios.servicioId ";
        $consulta .= "WHERE fecha = '$fecha' "; // Si deseas filtrar por fecha

        $citas = AdminCita::SQL($consulta);

        // Renderizar la vista con los datos obtenidos
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}
