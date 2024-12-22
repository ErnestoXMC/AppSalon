<?php

namespace Controllers;

use MVC\Router;

class ValidController{
    public static function error(Router $router){
        $router->render('error/error');
    }
}

?>