<?php

require_once __DIR__ . '/../model/Clientes.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';

use model\Clientes;
use dao\ClienteDAO;

header('Content-Type: application/json; charset=utf-8');

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
                empty($input["clave"]) ||
                empty($input["idRol"])
            ) {
                $respuesta = ["error" => "Faltan datos obligatorios"];
                break;
            }

            // Validar correo
            if (!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
                $respuesta = ["error" => "Correo inválido"];
                break;
            }

            $cliente = new Clientes(
                0, // ID autoincrement
                $input["nombre"],
                $input["apellido"],
                $input["correo"],
                $input["clave"],
                (int)$input["idRol"]
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
