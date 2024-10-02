<?php

namespace Classes;

class Email{
    
    public $nombre;
    public $email;
    public $token;
    
    public function __construct($nombre, $email, $token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }
}
?>