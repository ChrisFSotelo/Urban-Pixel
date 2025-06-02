<?php

namespace controller;
session_start();

require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';
header('Content-Type: application/json; charset=utf-8');

use model\Usuario;
use dao\UsuarioDAO;

class UsuarioControlador{

    public function AutenticarUsuario(){
        if(isset($_REQUEST["accion"]) && $_REQUEST["accion"] == "autenticar"){
            $usuarioDAO = new UsuarioDAO();
            $input = $_POST;

            if (empty($input["correo"]) || empty($input["clave"])) {
                $respuesta = ["error" => "Faltan datos obligatorios"];
                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Validar formato del correo
            if (!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
                $respuesta = ["error" => "Correo inválido"];
                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
                exit;
            }
            $correo = $input["correo"];
            $clave = md5($input["clave"]);

            $resultado = $usuarioDAO->AutenticarUsuario($correo, $clave);

            if($resultado === null){
                $respuesta = ["error" => "Error al autenticar usuario"];
            } else{

                $_SESSION["id"] = $resultado->getIdPersona();
                $_SESSION["correo"] = $correo;

                $respuesta = [
                    "mensaje" => "Usuario autenticado correctamente",
                    "usuario" => [
                        "id" => $resultado->getIdPersona(),
                    ]
                ];
            }
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}

if (isset($_GET["accion"]) && $_GET["accion"] === "autenticar") {
    $controlador = new UsuarioControlador();
    $controlador->AutenticarUsuario();
}