<?php

namespace controller;
session_start();

require_once '../model/Usuario.php';
require_once '../dao/UsuarioDAO.php';
require_once '../model/Clientes.php';
require_once '../dao/ClienteDAO.php';
header('Content-Type: application/json; charset=utf-8');

use dao\ClienteDAO;
use dao\UsuarioDAO;
use Usuario;

class UsuarioControlador{

    public function AutenticarUsuario() {
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
            $usuarioAutenticado = new Usuario(
                (int) $usuario['id'],
                $usuario['nombre'],
                $usuario['apellido'],
                $usuario['correo'],
                '',
                (int) $usuario['idEstado'],
                (int) $usuario['idRol'],
            );

            if($usuarioAutenticado->getEstado() === 0) {
                echo json_encode(['error' => 'Su cuenta está inactiva. Comuniquese con el administrador'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $_SESSION["usuario"] = $usuarioAutenticado;
            echo json_encode([
                "mensaje" => "Usuario autenticado correctamente",
                "usuario" => [
                    "id" => $usuarioAutenticado->getIdPersona(),
                    "rol" => $usuarioAutenticado->getRol()
                ]
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Intentar autenticar como cliente
        $clienteDAO = new ClienteDAO();
        $cliente = $clienteDAO->AutenticarCliente($correo, $clave);

        if($cliente !== null) {
            $usuarioAutenticado = new Usuario(
                (int) $cliente['id'],
                $cliente['nombre'],
                $cliente['apellido'],
                $cliente['correo'],
                '',
                (int) $cliente['idEstado'],
                (int) $cliente['idRol'],
            );

            if($usuarioAutenticado->getEstado() === 0) {
                echo json_encode(['error' => 'Su cuenta está inactiva. Comuniquese con el administrador'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $_SESSION["usuario"] = $usuarioAutenticado;
            echo json_encode([
                "mensaje" => "Cliente autenticado correctamente",
                "usuario" => [
                    "id" => $usuarioAutenticado->getIdPersona(),
                    "rol" => $usuarioAutenticado->getRol()
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