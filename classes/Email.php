<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    
    public $nombre;
    public $email;
    public $token;
    
    public function __construct($nombre, $email, $token){
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    }

    public function confirmarCuenta(){

        //Crear objeto de mailtrap
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        //Configurando los emails de envio y recepcion
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = "Confirma tu cuenta!";

        //Cuerpo del email
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado una cuenta en App Salon, confirma tu cuenta dando click en el siguiente enlace</p>";
        $contenido .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token=". $this->token ."'>Confirma tu Cuenta.</a></p>";
        $contenido .= "<p>Si no solicitaste crear una cuenta en App Salon, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar mensaje
        $mail->send();
    }

    public function enviarInstrucciones(){
          //Crear objeto de mailtrap
          $mail = new PHPMailer();
          $mail->isSMTP();
          $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];
  
          //Configurando los emails de envio y recepcion
          $mail->setFrom('cuentas@appsalon.com');
          $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
          $mail->Subject = "Reestablece tu password!";
  
          //Cuerpo del email
          $mail->isHTML(TRUE);
          $mail->CharSet = "UTF-8";
  
          $contenido = "<html>";
          $contenido .= "<p>Hola<strong> " . $this->nombre . "</strong> Reestablece tu password en App Salon dando click en el siguiente enlace</p>";
          $contenido .= "<p>Presiona Aquí: <a href='" . $_ENV['APP_URL'] . "/recuperar?token=". $this->token ."'>Reestablecer Password.</a></p>";
          $contenido .= "<p>Si no solicitaste reestablecer tu password en App Salon, puedes ignorar el mensaje</p>";
          $contenido .= "</html>";
  
          $mail->Body = $contenido;
  
          //Enviar mensaje
          $mail->send();
    }
}
?>