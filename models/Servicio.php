<?php

namespace Model;

class Servicio extends ActiveRecord{

    public static $tabla = 'servicios';
    public static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args =[]){
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar(){
        
        $longNombre = strlen($this->nombre);
        $longPrecio = strlen($this->precio);

        if(!$this->nombre){
            self::$alertas['error'][] = "El nombre es obligatorio";
        }
        if($this->nombre && $longNombre > 60){
            self::$alertas['error'][] = "El nombre del servicio no debe exceder los 60 caracteres";
        }

        if(!$this->precio){
            self::$alertas['error'][] = "El precio es obligatorio";
        }
        if($this->precio && $longPrecio > 3){
            self::$alertas['error'][] = "El precio maximo es de 999";
        }

        return self::$alertas;
    }
}
?>