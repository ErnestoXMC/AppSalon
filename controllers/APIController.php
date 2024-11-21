<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController{

    public static function index(){
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar(){
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $idServicios = explode(",", $_POST['servicios']);
        $id = $resultado['id'];

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $result = $citaServicio->guardar();
        }
        $response = [
            "cita" => $resultado['resultado'],
            "idCita" => $resultado['id'],
            "citaServicio" => $result['resultado'],
            "idServicio" => $result['id']
        ];
        echo json_encode($response);
    }
}
?>