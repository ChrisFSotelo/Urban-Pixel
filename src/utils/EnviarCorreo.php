<?php
namespace utils;
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../../logs/error.log');

require_once __DIR__ . '/../lib/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/SMTP.php';
require_once __DIR__ . '/../lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender {
    public static function enviarCorreoRecuperacion($correoDestino, $idUsuario, $tipo) {
        $mail = new PHPMailer(true);
        $link = "http://localhost:8000/src/features/users/view/CambiarPassword.php?id=$idUsuario&tipo=$tipo";

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'pixel.tornado.pt@gmail.com';
            $mail->Password   = 'jpup qlto ymal vgdk';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('pixel.tornado.pt@gmail.com', 'Urban Pixel');
            $mail->addAddress($correoDestino);
            $mail->isHTML(true);
            $mail->Subject = 'Lo invitamos a que recupere su clave';
            $mail->Body    = "Recupera tu clave utilizando el siguiente link: <a href='$link'>Cambiar contraseña</a>";

            $mail->send();

            return true;
        } 
        catch (Exception $e) {
            return false;
        }
    }
}
