<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        $router->render('auth/login');
    }

    public static function logout(){
        echo "Desde logout";
    }

    public static function olvide(Router $router){
        $router->render('auth/olvide-password', [

        ]);
    }

    public static function recuperar(){
        echo "Desde Recuperar";
    }

    public static function crear(Router $router){
        $usuario = new Usuario;

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            //Verificar que no haya alertas
            if(empty($alertas)){
                //Verificar que el usuario no esté registrado
                echo "Pasaste la validacion";
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }







}
?>