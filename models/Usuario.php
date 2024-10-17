<?php

namespace Model;

class Usuario extends ActiveRecord{

    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta(): array{
        //Longitud de variables
        $longNom = strlen($this->nombre);
        $longApe = strlen($this->apellido);
        $longTel = strlen($this->telefono);
        $longEma = strlen($this->email);
        $longPass = strlen($this->password);

        if(!$this->nombre){
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if($this->nombre && $longNom > 60){
            self::$alertas['error'][] = "Su Nombre no debe exceder los 60 caracteres";
        }
        if(!$this->apellido){
            self::$alertas['error'][] = "El apellido es obligatorio";
        }
        if($this->apellido && $longApe > 60){
            self::$alertas['error'][] = "Su Apellido no debe exceder los 60 caracteres";
        }
        if(!$this->telefono){
            self::$alertas['error'][] = "El telefono es obligatorio";
        }
        if($this->telefono && ($longTel < 9 || $longTel > 9)){
            self::$alertas['error'][] = "El telefono debe tener 9 digitos";
        }
        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if($this->email && $longEma > 30){
            self::$alertas['error'][] = "Su email no debe exceder los 30 caracteres";
        }
        if(!$this->password){
            self::$alertas['error'][] = "El password es obligatorio";
        }
        if($this->password && $longPass < 6){
            self::$alertas['error'][] = "El password debe tener al menos 6 caracteres";
        }
        if($this->password && $longPass > 30){
            self::$alertas['error'][] = "Su password no debe exceder los 60 caracteres";
        }
        return self::$alertas;
    }

    public function validarLogin(){

        $longEma = strlen($this->email);
        $longPass = strlen($this->password);

        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if($this->email && $longEma > 30){
            self::$alertas['error'][] = "Su email no debe exceder los 30 caracteres";
        }

        if(!$this->password){
            self::$alertas['error'][] = "El password es obligatorio";
        }
        if($this->password && $longPass > 30){
            self::$alertas['error'][] = "Su password no debe exceder los 60 caracteres";
        }

        return self::$alertas;
    }

    public function validarEmail() : array {

        $longEma = strlen($this->email);

        if(!$this->email){
            self::$alertas['error'][] = "El email es obligatorio";
        }
        if($this->email && $longEma > 30){
            self::$alertas['error'][] = "Su email no debe exceder los 30 caracteres";
        }

        return self::$alertas;
    }

    public function validarPassword(): array{
        $longPass = strlen($this->password);

        if(!$this->password){
            self::$alertas['error'][] = "El password es obligatorio";
        }
        if($this->password && $longPass < 6){
            self::$alertas['error'][] = "El password debe tener al menos 6 caracteres";
        }
        if($this->password && $longPass > 30){
            self::$alertas['error'][] = "Su password no debe exceder los 60 caracteres";
        }
        
        return self::$alertas;
    }

    public function verificarUsuario(){
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";
        
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = "El usuario ya esta registrado";
        }
        return $resultado;
    }

    public function hashPassword(): void{
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }
    
    public function crearToken(): void{
        $this->token = uniqid();
    }

    public function verificarPassword($password){
        $resultado = password_verify($password, $this->password);
        if(!$resultado){
            self::$alertas['error'][] = "Password incorrecto";
            return false;
        }
        return true;
    }

    public function verificarCuenta(){
        if(!$this->confirmado){
            self::$alertas['error'][] = "Tu cuenta no esta confirmada";
            return false;
        }else{
            return true;
        }
    }




}

?>