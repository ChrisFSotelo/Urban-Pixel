<?php
namespace utils;
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../../../logs/error.log');

require_once __DIR__ . '/../lib/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer/SMTP.php';
require_once __DIR__ . '/../lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{
    public static function enviarCorreoRecuperacion($correoDestino, $idUsuario, $tipo)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'pixel.tornado.pt@gmail.com';
            $mail->Password   = 'jpup qlto ymal vgdk';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('pixel.tornado.pt@gmail.com', 'Urban-Pixel');
            $mail->addAddress($correoDestino);

            $link = "http://localhost:8000/src/features/users/view/CambiarPassword.php?tipo=$tipo&id=$idUsuario";

            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = "Recupera tu clave aquí: <a href='$link'>Cambiar contraseña</a>";

            $mail->send();
            error_log("Correo enviado exitosamente a $correoDestino");

            return true;
        } catch (Exception $e) {
            error_log("Error al enviar correo a $correoDestino: " . $mail->ErrorInfo);
            return false;
        }
    }
}
