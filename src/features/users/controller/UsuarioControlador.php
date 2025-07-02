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
    public function listarExcluyendoActual() {
        $usuarioDAO = new UsuarioDAO();

        if(!isset($_GET['idUserAuth'])) {
            echo json_encode(["error" => "Faltan datos en la consulta"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $idUsuarioAuth = (int) $_GET['idUserAuth'];
        $usuarios = $usuarioDAO->listarExcluyendoActual($idUsuarioAuth);

        if($usuarios === null)
            $respuesta = ["error" => "No se encontraron admins"];
        else {
            $respuesta = $usuarios;
            
            if(!empty($respuesta)){
                for($i = 0; $i < count($respuesta); $i++){
                    $respuesta[$i]["no"] = $i + 1;
                    $respuesta[$i]["clave"] = "";
                    $estado = $respuesta[$i]["idEstado"] == 1 ? "Activo" : "Inactivo";
                    $respuesta[$i]["idEstado"] = $estado;
                    $respuesta[$i]["editar"] = 
                        '<button 
                            class="btn btn-primary" 
                            type="button" 
                            title="Editar" 
                            onclick="obtenerAdminInfo('.$respuesta[$i]["id"].')"
                        >
                            <i class="fa-solid fa-pencil"></i>
                        </button>';
                    $respuesta[$i]["eliminar"] = 
                        '<button 
                            class="btn btn-danger" 
                            type="button" 
                            title="Eliminar"
                            onclick="confirmarEliminacionAdmin('.$respuesta[$i]["id"].')"
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
        $usuarioDAO = new UsuarioDAO();

        // Validar que se reciba el ID por GET
        if(empty($_GET["id"])) {
            $respuesta = ["error" => "ID no proporcionado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = $_GET["id"];
        $usuario = $usuarioDAO->obtenerPorId($id);

        if($usuario === null)
            $respuesta = ["error" => "No se encontro el usuario con ID: $id"];
        else {
            $usuario["clave"] = ""; // No mostrar la clave
            $respuesta = $usuario;
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function regitarAdmin() {
        $usuarioDAO = new UsuarioDAO();

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
        if($usuarioDAO->obtenerPorCorreo($input["correo"]) !== null) {
            $respuesta = ["error" => "El correo ya está registrado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $idRolAdmin = 1;
        $estado = 1;
        // Cifrar la contraseña con md5
        $clave = md5($input["clave"]);

        $usuario = new Usuario(
            0, // ID autoincrementable
            $input["nombre"],
            $input["apellido"],
            $input["correo"],
            $clave,
            $idRolAdmin,
            $estado
        );

        // Registrar en base de datos
        $resultado = $usuarioDAO->registarAdmin($usuario);

        if($resultado === null)
            $respuesta = ["error" => "Error al registrar cliente"];
        else {
            $respuesta = [
                "mensaje" => "Administrador registrado correctamente",
                "admin" => [
                    "nombre" => $usuario->getNombre(),
                    "apellido" => $usuario->getApellido(),
                    "correo" => $usuario->getCorreo(),
                    "idRol" => $usuario->getRol(),
                    "estado" => $usuario->getEstado()
                ]
            ];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function actualizarAdmin() {
        $usuarioDAO = new UsuarioDAO();
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
        if($usuarioDAO->obtenerPorCorreoExcluyendoActual($input["id"], $input["correo"]) !== null) {
            $respuesta = ["error" => "El correo ya está registrado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $usuarioPorId = $usuarioDAO->obtenerPorId($input["id"]);

        // Verificar si el cliente existe
        if($usuarioPorId === null) {
            $respuesta = ["error" => "No se encontró el admin con ID: " . $input["id"]];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        // Crear objeto cliente
        $usuario = new Usuario(
            $usuarioPorId["id"], // ID del cliente a actualizar
            $input["nombre"],
            $input["apellido"],
            $input["correo"],
            "",
            $usuarioPorId["idRol"], // Mantener el mismo rol
            $usuarioPorId["idEstado"]
        );

        if($input["clave"] !== "") {
            // Cifrar la contraseña con md5 si se proporciona
            $usuario->setClave(md5($input["clave"]));
        } 
        else {
            // Si no se proporciona clave, mantener la existente
            $usuario->setClave($usuarioPorId["clave"]);
        }

        // Actualizar en base de datos
        $resultado = $usuarioDAO->actualizar($usuario);

        if($resultado === null)
            $respuesta = ["error" => "Error al actualizar al administrador"];
        else {
            $respuesta = [
                "mensaje" => "Administrador actualizado correctamente",
                "admin" => [
                    "id" => $usuario->getIdPersona(),
                    "nombre" => $usuario->getNombre(),
                    "apellido" => $usuario->getApellido(),
                    "correo" => $usuario->getCorreo(),
                    "idRol" => $usuario->getRol()
                ]
            ];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function actualizarSesion() {
        $usuarioDAO = new UsuarioDAO();

        if(empty($_GET["id"])) {
            echo json_encode(["error" => "ID no proporcionado"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $usuarioPorId = $usuarioDAO->obtenerPorId($_GET["id"]);
        if($usuarioPorId === null) {
            echo json_encode(['error' => 'Hubo un error al actualizar la sesion. Intentelo nuevamente'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $usuarioAutenticado = new Usuario(
            (int) $usuarioPorId['id'],
            $usuarioPorId['nombre'],
            $usuarioPorId['apellido'],
            $usuarioPorId['correo'],
            '',
            (int) $usuarioPorId['idEstado'],
            (int) $usuarioPorId['idRol'],
        );

        $_SESSION["usuario"] = $usuarioAutenticado;

        echo json_encode(['mensaje' => 'Perfil actualizado correctamente'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function actualizarEstadoAdmin() {
        $input = $_POST;

        if (empty($input["id"]) || !isset($input["estado"])) {
            echo json_encode(["error" => "Faltan parámetros obligatorios"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = intval($input["id"]);
        $estadoActual = intval($input["estado"]);
        $nuevoEstado = $estadoActual == 1 ? 0 : 1;

        $usuarioDAO = new UsuarioDAO();

        // Verificar que el cliente exista antes de actualizar
        $usuarioActual = $usuarioDAO->obtenerPorId($id);
        if ($usuarioActual === null) {
            echo json_encode(["error" => "Admin no encontrado"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $resultado = $usuarioDAO->actualizarEstado($id, $nuevoEstado);

        if($resultado) {
            $respuesta = [
                "mensaje" => "Estado actualizado correctamente",
                "admin" => [
                    "id" => $id,
                    "estado" => $nuevoEstado
                ]
            ];
        } 
        else {
            $respuesta = ["error" => "No se pudo actualizar el estado"];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function eliminarAdmin() {
        $usuarioDAO = new UsuarioDAO();
        $input = $_GET;

        if (empty($input["idAdmin"])) {
            echo json_encode(["error" => "Faltan parámetros obligatorios"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = intval($input["idAdmin"]);

        // Verificar que el admin exista antes de actualizar
        $usuarioActual = $usuarioDAO->obtenerPorId($id);
        if ($usuarioActual === null) {
            echo json_encode(["error" => "Admin no encontrado"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $resultado = $usuarioDAO->eliminar($id);

        if($resultado)
            $respuesta = ["mensaje" => "Administrador eliminado correctamente"];
        else
            $respuesta = ["error" => "No se pudo eliminar al administrador"];

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

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
if(isset($_GET["accion"]) && $_GET["accion"] === "listarAdmins") {
    $controlador = new UsuarioControlador();
    $controlador->listarExcluyendoActual();
}
if(isset($_GET["accion"]) && $_GET["accion"] === "registrar") {
    $controlador = new UsuarioControlador();
    $controlador->regitarAdmin();
}
if(isset($_GET["accion"]) && $_GET["accion"] === "obtenerPorId") {
    $controlador = new UsuarioControlador();
    $controlador->obtenerPorId();
}
if(isset($_GET["accion"]) && $_GET["accion"] === "actualizar") {
    $controlador = new UsuarioControlador();
    $controlador->actualizarAdmin();
}
if(isset($_GET["accion"]) && $_GET["accion"] === "actualizarSesion") {
    $controlador = new UsuarioControlador();
    $controlador->actualizarSesion();
}
if(isset($_GET["accion"]) && $_GET["accion"] === "actualizarEstado") {
    $controlador = new UsuarioControlador();
    $controlador->actualizarEstadoAdmin();
}
if(isset($_GET["accion"]) && $_GET["accion"] === "eliminar") {
    $controlador = new UsuarioControlador();
    $controlador->eliminarAdmin();
}