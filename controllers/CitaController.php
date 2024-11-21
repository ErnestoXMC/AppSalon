<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class CitaController{

    public static function index(Router $router){
        session_start();
        
        isAuth();

        $nombre = $_SESSION['nombre'];
        $id = $_SESSION['id'];
        
        $router->render('cita/index', [
            'nombre' => $nombre,
            'id' => $id
        ]);
    }
}
?>