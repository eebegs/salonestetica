<?php

namespace Controllers;

use Model\cita;
use Model\CitaServicio;
use Model\Servicio;

class APIcontroller {
    public static function index() {
        $servicios = Servicio::all();

        echo json_encode($servicios);
    }
    
    public static function guardar() {

        //Almacena la cita y devuelve Id
        $cita = new cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        //Almacena la cita y el servicio

        //Almacena los servicios con el ID de la Cita
        $idServicios = explode(",", $_POST['servicios']);

        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }


        //Retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    
    public static function eliminar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
    
            if (empty($id)) {
                echo 'ID no proporcionado.';
                return;
            }
    
            // Crea una instancia de Cita
            $cita = Cita::find($id);
            if ($cita) {
                // Llama al método eliminar
                $cita->eliminar();
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                echo 'Cita no encontrada.';
            }
        }
    }
}