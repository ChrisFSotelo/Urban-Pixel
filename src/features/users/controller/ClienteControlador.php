<?php

require_once __DIR__ . '/../model/Clientes.php';
require_once __DIR__ . '/../dao/ClienteDAO.php';
header('Content-Type: application/json; charset=utf-8');

use model\Clientes;
use dao\ClienteDAO;

class ClienteControlador{

    public function RegistrarCliente(){

            $nombre = preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["nombre"]);
            $apellido = preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["apellido"]);
            $correo = $_POST["correo"];
            $clave = $_POST["clave"];

            $cliente = new Clientes();
            $cliente->setNombre($nombre);
            $cliente->setApellido($apellido);
            $cliente->setCorreo($correo);
            $cliente->setClave($clave);
            $cliente->setIdRol(2);

            $clienteDAO = new ClienteDAO();
            $resultado = $clienteDAO->RegistrarCliente($cliente);
            $respuesta = null;
            if ($resultado) {
                echo "Error al registrar el cliente";
//                echo'<script>
//				swal({
//					type: "success",
//					title: "Un nuevo Lead ha sido registrado",
//					showConfirmButton: true,
//					confirmButtonText: "Cerrar"
//					}).then(function(result){
//						if (result.value) {
//							window.location = "leads";
//						}
//					})
//				</script>';
                exit();
            } else {
                echo "Error al registrar el cliente";
            }
    }
}

//if (isset($_REQUEST["accion"])) {
//    $accion = $_REQUEST["accion"];
//    $clienteDAO = new ClienteDAO();
//    $respuesta = null;
//
//    switch ($accion) {
//        case "registrar": {
//            // Validamos que los datos vengan por POST
//            $input = $_POST;
//
//            if (
//                empty($input["nombre"]) ||
//                empty($input["apellido"]) ||
//                empty($input["correo"]) ||
//                empty($input["clave"]) ||
//                empty($input["idRol"])
//            ) {
//                $respuesta = ["error" => "Faltan datos obligatorios"];
//                break;
//            }
//
//            // Validar correo
//            if (!filter_var($input["correo"], FILTER_VALIDATE_EMAIL)) {
//                $respuesta = ["error" => "Correo inválido"];
//                break;
//            }
//
//            $cliente = new Clientes(
//                0, // ID autoincrement
//                $input["nombre"],
//                $input["apellido"],
//                $input["correo"],
//                $input["clave"],
//                (int)$input["idRol"]
//            );
//
//            $resultado = $clienteDAO->RegistrarCliente($cliente);
//
//            if ($resultado === null) {
//                $respuesta = ["error" => "Error al registrar cliente"];
//            } else {
//                $respuesta = [
//                    "mensaje" => "Cliente registrado correctamente",
//                    "cliente" => [
//                        "nombre" => $cliente->getNombre(),
//                        "apellido" => $cliente->getApellido(),
//                        "correo" => $cliente->getCorreo(),
//                        "idRol" => $cliente->getIdRol()
//                    ]
//                ];
//            }
//
//            break;
//        }
//    }
//
//    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
//} else {
//    header("Location: ../../../../");
//}
