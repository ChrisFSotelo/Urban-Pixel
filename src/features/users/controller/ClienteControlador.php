<?php

require_once __DIR__ . '/../model/Clientes.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
header('Content-Type: application/json; charset=utf-8');

use model\Clientes;
use dao\ClienteDAO;

class ClienteControlador{

    public function RegistrarCliente() {
        if (isset($_REQUEST["accion"]) && $_REQUEST["accion"] == "registrar") {
            $clienteDAO = new ClienteDAO();
            $respuesta = null;

            // Capturar inputs del formulario POST
            $input = $_POST;

            // Validación de campos obligatorios
            if (empty($input["nombre"]) || empty($input["apellido"]) ||
                empty($input["correo"]) || empty($input["clave"])) {
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

            $idRolCliente = 2;

            // Cifrar la contraseña con md5
            $clave = md5($input["clave"]);

            // Crear objeto cliente
            $cliente = new Clientes(
                0, // ID autoincrement
                $input["nombre"],
                $input["apellido"],
                $input["correo"],
                $clave,
                $idRolCliente
            );

            // Registrar en base de datos
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

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}

// ✅ Este bloque es el que activa la ejecución del método
if (isset($_GET["accion"]) && $_GET["accion"] === "registrar") {
    $controlador = new ClienteControlador();
    $controlador->RegistrarCliente();
}
