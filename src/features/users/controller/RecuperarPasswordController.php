<?php

require_once '../../../utils/EnviarCorreo.php';
require_once '../dao/ClienteDAO.php';
require_once '../dao/UsuarioDAO.php';
header('Content-Type: application/json; charset=utf-8');

use utils\EmailSender;
use dao\ClienteDAO;
use dao\UsuarioDAO;

class RecuperarPasswordController {
    public function enviarCorreo() {
        $clienteDAO = new ClienteDAO();

        if(empty($_POST["correo"])) {
            echo json_encode(["error" => "Correo no proporcionado"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $correo = $_POST["correo"];
        $usuario = $clienteDAO->obtenerPorCorreo($correo);

        if($usuario === null) {
            echo json_encode(["error" => "Usuario no encontrado"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = $usuario["id"];
        $rol = $usuario["idRol"] === 1 ? "Administrador" : "Cliente";
        $respuesta = EmailSender::enviarCorreoRecuperacion($correo, $id, $rol);

        if($respuesta) {
            echo json_encode(["mensaje" => "Correo enviado exitosamente"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(["error" => "Hubo un error al enviar el correo"], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function recuperarClave() {
        $clienteDAO = new ClienteDAO();
        $usuarioDAO = new UsuarioDAO();

        if(empty($_GET["tipo"]) || empty($_GET["id"]) || empty($_POST["nuevaClave"])) {
            echo json_encode(["error" => "Datos no proporcionados"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = $_GET["id"];
        $rol = $_GET["tipo"];
        $nuevaClave = md5($_POST["nuevaClave"]);

        if($rol === "Administrador")
            $respuesta = $usuarioDAO->cambiarClave($id, $nuevaClave);
        else if($rol === "Cliente")
            $respuesta = $clienteDAO->cambiarClave($id, $nuevaClave);

        if($respuesta) {
            echo json_encode(["mensaje" => "Contraseña restaurada con exito"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        echo json_encode(["error" => "No se pudo restaurar la contraseña"], JSON_UNESCAPED_UNICODE);
        exit;
    }
}

if(isset($_GET["accion"]) && $_GET["accion"] === "enviarCorreo") {
    $controlador = new RecuperarPasswordController();
    $controlador->enviarCorreo();
}

if(isset($_GET["accion"]) && $_GET["accion"] === "recuperarClave") {
    $controlador = new RecuperarPasswordController();
    $controlador->recuperarClave();
}
