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
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'e3b958a8064673';
        $mail->Password = '17aa41fad929f1';

        //Configurando los emails de envio y recepcion
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = "Confirma tu cuenta!";

        //Cuerpo del email
        $mail->isHTML(TRUE);
        $mail->CharSet = "UTF-8";

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado una cuenta en App Salon, confirma tu cuenta dando click en el siguiente enlace</p>";
        $contenido .= "<p>Presiona Aquí: <a href= 'http://localhost:3000/confirmar-cuenta?token=". $this->token ."'>Confirma tu Cuenta.</a></p>";
        $contenido .= "<p>Si no solicitaste crear una cuenta en App Salon, puedes ignorar el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar mensaje
        $mail->send();



    }
}
?>