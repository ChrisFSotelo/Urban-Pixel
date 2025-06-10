<?php

namespace controller;
session_start();

require_once __DIR__ . '/../model/Usuario.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

require_once __DIR__ . '/../model/Clientes.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
header('Content-Type: application/json; charset=utf-8');

use dao\ClienteDAO;
use model\Usuario;
use dao\UsuarioDAO;

class UsuarioControlador{

    public function AutenticarUsuario() {
        //    error_log("POST recibido: " . print_r($_POST, true)); // <== aquí
            $input = $_POST;

            if (empty($input["correo"]) || empty($input["clave"])) {
                echo json_encode(["error" => "Faltan datos obligatorios"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            if (!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
                echo json_encode(["error" => "Correo inválido"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $correo = $input["correo"];
            $clave = md5($input["clave"]);

            // Intentar autenticar como usuario
            $usuarioDAO = new UsuarioDAO();
            $usuario = $usuarioDAO->AutenticarUsuario($correo, $clave);

            if ($usuario !== null) {
                $_SESSION["id"] = $usuario->getIdPersona();
                $_SESSION["correo"] = $correo;
                $_SESSION["rol"] = "usuario";

                echo json_encode([
                    "mensaje" => "Usuario autenticado correctamente",
                    "usuario" => [
                        "id" => $usuario->getIdPersona(),
                        "rol" => "usuario"
                    ]
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Intentar autenticar como cliente
            $clienteDAO = new ClienteDAO();
            $cliente = $clienteDAO->AutenticarCliente($correo, $clave);

            if ($cliente !== null) {
                $_SESSION["id"] = $cliente->getId();
                $_SESSION["correo"] = $correo;
                $_SESSION["rol"] = $cliente->getIdRol(); // si aplica

                echo json_encode([
                    "mensaje" => "Cliente autenticado correctamente",
                    "usuario" => [
                        "id" => $cliente->getId(),
                        "rol" => $cliente->getIdRol()
                    ]
                ], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Si ninguno fue válido
            echo json_encode(["error" => "Credenciales inválidas"], JSON_UNESCAPED_UNICODE);
            exit;

    }

}

if (isset($_GET["accion"]) && $_GET["accion"] === "autenticar") {
    $controlador = new UsuarioControlador();
    $controlador->AutenticarUsuario();
}