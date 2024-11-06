<?php 

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {

    public $email;
    public $nombre;
    public $token;
    
    public function __construct($nombre, $email, $token)
    {

        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
        
    }

    public function enviarConfirmacion() {

        //Crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com', 'Appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<body style='font-family: Arial, sans-serif; color: #333;'>";
        $contenido .= "<div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #ffead2;'>";
        $contenido .= "<p style='font-size: 18px;'><strong>Hola " . $this->nombre . "</strong></p>";
        $contenido .= "<p style='font-size: 16px; line-height: 1.5;'>Has creado tu cuenta en Estetica Donna, solo debes confirmar presionando el siguiente enlace:</p>";
        $contenido .= "<p><a href='" .  $_ENV['PROJECT_URL']  . "/confirmar-cuenta?token=" . $this->token . "' style='display: inline-block; background-color: #ff00ac; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Confirmar cuenta</a></p>";
        $contenido .= "<p style='font-size: 14px; color: #555;'>Si tú no solicitaste esta cuenta, puedes ignorar este mensaje.</p>";
        $contenido .= "</div>";
        $contenido .= "</body>";
        $contenido .= "</html>";
        
        $mail->Body = $contenido;
        

        //Enviar el email 

        $mail->send();

    }

    public function enviarInstrucciones() {
        //Crear el objeto de email

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@appsalon.com', 'Appsalon.com');
        $mail->addAddress($this->email, $this->nombre);
        $mail->Subject = 'Reestablece tu contrasena';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<body style='font-family: Arial, sans-serif; color: #333;'>";
        $contenido .= "<div style='max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #ffead2;'>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestableces tu contrasena, sigue el siguiente enlace para hacerlo</p>";
        $contenido .= "<p>Presiona aqui: <a href='" .  $_ENV['PROJECT_URL']  . "/recuperar?token=" . $this->token . "'style='display: inline-block; background-color: #ff00ac; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>Reestablecer contrasena</a> </p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        //Enviar el email 

        $mail->send();
    }
}
