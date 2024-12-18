<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{

    public static function login(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario){
                    //Verificar si esta confirmado
                    $resultado = $usuario->verificarPassword($auth->password);
                    if($resultado){
                        $verificar = $usuario->verificarCuenta();
                        if($verificar){
                            session_start();

                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;

                            if($usuario->admin){
                                $_SESSION['admin'] = $usuario->admin ?? null;
                                header("Location: /admin");
                            }else{
                                $_SESSION['admin'] = null;
                                header("Location: /citas");
                            }
                        }
                    }
                    
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            "alertas" => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];

        header("Location: /");
    }

    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
           
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario){
                    if($usuario->confirmado === '1'){

                        $usuario->crearToken();
                        $usuario->guardar();

                        $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                        $email->enviarInstrucciones();
                        
                        Usuario::setAlerta('exito', 'Revisa tu email');
                        
                    }else{
                        Usuario::setAlerta('error', 'El usuario no esta confirmado');
                    }
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }

    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        if($token){
            $usuario = Usuario::where('token', $token);
            if($usuario){
                if($_SERVER['REQUEST_METHOD'] === 'POST'){
                    $auth = new Usuario($_POST);
                    $alertas = $auth->validarPassword();

                    if(empty($alertas)){

                        $usuario->password = null;
                        $usuario->password = $auth->password;
                        $usuario->hashPassword();
                        $usuario->token = null;

                        $resultado = $usuario->guardar();
                        
                        if($resultado){
                            header("Location: /");
                        }


                    }
                }
            }else{
                Usuario::setAlerta('error', 'Token No Valido');
                $error = true;
            }
        }else{
            Usuario::setAlerta('error', 'El Token No existe');
            $error = true;
        }
        
        $alertas = Usuario::getAlertas();
        
        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router){
        $usuario = new Usuario;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            //Verificar que no haya alertas
            if(empty($alertas)){
                //Verificar que el usuario no esté registrado
               $resultado = $usuario->verificarUsuario();
               if($resultado->num_rows){
                    $alertas = Usuario::getAlertas();
               }else{
                    //Hashear Password
                    $usuario->hashPassword();
                    //Generar Token unico
                    $usuario->crearToken();

                    //Enviar Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->confirmarCuenta();

                    //Guardar el usuario 
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                        exit();
                    }
               }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function confirmar(Router $router){
        $alertas = [];
        
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token No Válido');
        }else{
            //Actualizamos los campos del usuario
            $usuario->confirmado = "1";
            $usuario->token = null;
            //Actualizamos en la BD
            $usuario->guardar();
            //Mostramos mensaje de alerta
            Usuario::setAlerta('exito', 'Cuenta Confirmada Correctamente');
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);

    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }
}
?>