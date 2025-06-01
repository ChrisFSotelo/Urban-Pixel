<?php

require_once __DIR__ . '/../model/Clientes.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
header('Content-Type: application/json; charset=utf-8');

use model\Clientes;
use dao\ClienteDAO;



if (isset($_REQUEST["accion"])) {
    $accion = $_REQUEST["accion"];
    $clienteDAO = new ClienteDAO();
    $respuesta = null;

    switch ($accion) {
        case "registrar": {
            // Validamos que los datos vengan por POST
            $input = $_POST;

            if (
                empty($input["nombre"]) ||
                empty($input["apellido"]) ||
                empty($input["correo"]) ||
                empty($input["clave"])

            ) {
                $respuesta = ["error" => "Faltan datos obligatorios"];
                break;
            }

            // Validar correo
            if (!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
                $respuesta = ["error" => "Correo inválido"];
                break;
            }

            $idRolCliente = 2;

            // Cifrar la contraseña antes de guardar
            $clave = md5($input["clave"]);
            $cliente = new Clientes(
                0, // ID autoincrement
                $input["nombre"],
                $input["apellido"],
                $input["correo"],
                $clave,
                $idRolCliente
            );

            $resultado = $clienteDAO->RegistrarCliente($cliente);

            if ($resultado === null) {
                $respuesta = ["error" => "Error al registrar cliente"];
            } else {
                $respuesta = [
                    "mensaje" => "Cliente registrado correctamente",
                    "cliente" => [
                        "nombre" => $cliente->getNombre(),
                        "apellido" => $cliente->getApellido(),
                        "correo" => $cliente->getCorreo(),
                        "idRol" => $cliente->getIdRol()
                    ]
                ];
            }

            break;
        }
    }

    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
} else {
    header("Location: ../../../../");
}
