<?php

require_once __DIR__ . '/../model/Clientes.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
header('Content-Type: application/json; charset=utf-8');

use model\Clientes;
use dao\ClienteDAO;

class ClienteControlador{
    public function listar() {
        $clienteDAO = new ClienteDAO();
        $clientes = $clienteDAO->listar();

        if($clientes === null)
            $respuesta = ["error" => "No se encontraron clientes"];
        else {
            $respuesta = $clientes;
            
            if(!empty($respuesta)){
                for($i = 0; $i < count($respuesta); $i++){
                    $respuesta[$i]["no"] = $i + 1;
                    $respuesta[$i]["clave"] = "";
                    $respuesta[$i]["lead"] = '<button class="btn btn-info" type="button"><i class="fa-solid fa-info"></i></button>';
                    $respuesta[$i]["editar"] = 
                        '<button 
                            class="btn btn-primary" 
                            type="button" 
                            title="Editar" 
                            onclick="obtenerClienteInfo('.$respuesta[$i]["id"].')"
                        >
                            <i class="fa-solid fa-pencil"></i>
                        </button>';
                    $respuesta[$i]["eliminar"] = 
                        '<button 
                            class="btn btn-danger" 
                            type="button" 
                            title="Eliminar"
                            onclick="confirmarEliminacion('.$respuesta[$i]["id"].')"
                        >
                            <i class="fa-solid fa-times"></i>
                        </button>';
                }
            }
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function obtenerPorId() {
        $clienteDAO = new ClienteDAO();

        // Validar que se reciba el ID por GET
        if(empty($_GET["id"])) {
            $respuesta = ["error" => "ID no proporcionado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = $_GET["id"];
        $cliente = $clienteDAO->obtenerPorId($id);

        if($cliente === null)
            $respuesta = ["error" => "No se encontro el cliente con ID: $id"];
        else {
            $cliente["clave"] = ""; // No mostrar la clave
            $respuesta = $cliente;
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function RegistrarCliente() {
        $clienteDAO = new ClienteDAO();
        $respuesta = null;

        // Capturar inputs del formulario POST
        $input = $_POST;

        // Validación de campos obligatorios
        if(empty($input["nombre"]) || empty($input["apellido"]) ||
            empty($input["correo"]) || empty($input["clave"])) {
            $respuesta = ["error" => "Faltan datos obligatorios"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar formato del correo
        if(!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
            $respuesta = ["error" => "Correo inválido"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Verificar si el correo ya está registrado
        if($clienteDAO->obtenerPorCorreo($input["correo"]) !== null) {
            $respuesta = ["error" => "El correo ya está registrado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $idRolCliente = 2;

        // Cifrar la contraseña con md5
        $clave = md5($input["clave"]);

        // Crear objeto cliente
        $cliente = new Clientes(
            0, // ID autoincrementable
            $input["nombre"],
            $input["apellido"],
            $input["correo"],
            $clave,
            $idRolCliente
        );

        // Registrar en base de datos
        $resultado = $clienteDAO->RegistrarCliente($cliente);

        if($resultado === null)
            $respuesta = ["error" => "Error al registrar cliente"];
        else {
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

    public function actualizarCliente() {
        $clienteDAO = new ClienteDAO();
        $respuesta = null;

        // Capturar inputs del formulario POST
        $input = $_POST;

        // Validación de campos obligatorios
        if(empty($input["id"]) || empty($input["nombre"]) || 
            empty($input["apellido"]) || empty($input["correo"])) {

            $respuesta = ["error" => "Faltan datos obligatorios"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Validar formato del correo
        if(!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
            $respuesta = ["error" => "Correo inválido"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Verificar si el correo ya está registrado, excluyendo el cliente actual
        if($clienteDAO->obtenerPorCorreoExcluyendoActual($input["id"], $input["correo"]) !== null) {
            $respuesta = ["error" => "El correo ya está registrado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $clientePorId = $clienteDAO->obtenerPorId($input["id"]);

        // Verificar si el cliente existe
        if($clientePorId === null) {
            $respuesta = ["error" => "No se encontró el cliente con ID: " . $input["id"]];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Crear objeto cliente
        $cliente = new Clientes(
            $clientePorId["id"], // ID del cliente a actualizar
            $input["nombre"],
            $input["apellido"],
            $input["correo"],
            "",
            $clientePorId["idRol"] // Mantener el mismo rol
        );

        if($input["clave"] !== "") {
            // Cifrar la contraseña con md5 si se proporciona
            $cliente->setClave(md5($input["clave"]));
        } 
        else {
            // Si no se proporciona clave, mantener la existente
            $cliente->setClave($clientePorId["clave"]);
        }

        // Actualizar en base de datos
        $resultado = $clienteDAO->actualizar($cliente);

        if($resultado === null)
            $respuesta = ["error" => "Error al actualizar al cliente"];
        else {
            $respuesta = [
                "mensaje" => "Cliente actualizado correctamente",
                "cliente" => [
                    "id" => $cliente->getId(),
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

// ✅ Este bloque es el que activa la ejecución del método
if(isset($_GET["accion"]) && $_GET["accion"] === "listar") {
    $controlador = new ClienteControlador();
    $controlador->listar();
}

if(isset($_GET["accion"]) && $_GET["accion"] === "obtenerPorId") {
    $controlador = new ClienteControlador();
    $controlador->obtenerPorId();
}

if(isset($_GET["accion"]) && $_GET["accion"] === "registrar") {
    $controlador = new ClienteControlador();
    $controlador->RegistrarCliente();
}

if(isset($_GET["accion"]) && $_GET["accion"] === "actualizar") {
    $controlador = new ClienteControlador();
    $controlador->actualizarCliente();
}