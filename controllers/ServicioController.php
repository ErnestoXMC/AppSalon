<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{

    public static function index(Router $router){
        session_start();
        isAdmin();
        $nombre = $_SESSION['nombre'];

        $servicios = Servicio::all();
        
        $router->render('servicios/index', [
            'servicios' => $servicios,
            'nombre' => $nombre
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAdmin();
        $nombre = $_SESSION['nombre'];

        $servicio = new Servicio;
        $alertas = [];
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /servicios");
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $nombre,
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);

    }

    public static function actualizar(Router $router){
        session_start();
        isAdmin();
        $nombre = $_SESSION['nombre'];

        $idValid = is_numeric($_GET['id']);
        if($idValid){
            $id = $_GET['id'];
            $servicio = Servicio::find($id);
            if(!$servicio){
                header("Location: /404");
            }
        }else{
            header("Location: /404");
        }       

        $alertas = [];
        
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                header("Location: /servicios");
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $nombre,
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    }

     public static function eliminar(){
        session_start();
        isAdmin();
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $servicio = Servicio::find($_POST['id']);
            $servicio->eliminar();
            header("Location: /servicios");
        }
    }

}
?>