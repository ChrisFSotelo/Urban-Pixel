<?php

require_once __DIR__ . '/../../../utils/EnviarCorreo.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
require_once __DIR__ . '/../dao/UsuarioDAO.php';

use utils\EmailSender;
use dao\ClienteDAO;
use dao\UsuarioDAO;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';

    if (empty($correo)) {
        http_response_code(400);
        echo "Correo no proporcionado.";
        exit;
    }

    $clienteDAO = new ClienteDAO();
    //$usuarioDAO = new UsuarioDAO();

    $cliente = $clienteDAO->obtenerPorCorreo($correo);
    // $usuario = $usuarioDAO->obtenerPorCorreo($correo);

    if ($cliente) {
        $id = is_array($cliente) ? $cliente['id'] : $cliente->getId();
        EmailSender::enviarCorreoRecuperacion($correo, $id, 'cliente');
        echo "Correo de recuperación enviado a cliente.";
    } 
    // elseif ($usuario) {
    //     $id = $usuario->getIdPersona();
    //     EmailSender::enviarCorreoRecuperacion($correo, $id, 'usuario');
    //     echo "Correo de recuperación enviado a usuario.";
    // } 
    else {
        http_response_code(404);
        echo "No se encontró una cuenta con ese correo.";
    }

    exit;
}
