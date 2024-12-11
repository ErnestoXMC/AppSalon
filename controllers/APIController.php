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

    public static function eliminar(){
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $id = $_POST['id'];
            $cita = Cita::find($id);
            if($cita){
                $cita->eliminar();
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }else{
                header("Location: /404");
            }
        }
        

    }
}
?>