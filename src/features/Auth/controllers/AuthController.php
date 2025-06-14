<?php
    require_once "../../users/model/Usuario.php";
    require_once "../../users/dao/UsuarioDAO.php";
    require_once "../../users/model/Clientes.php";
    require_once "../../users/dao/ClienteDAO.php";
    require_once "../../roles/dao/RolDAO.php";
    header('Content-Type: application/json; charset=utf-8');

    use dao\ClienteDAO;
    use dao\RolDAO;
    use dao\UsuarioDAO;
    use model\Clientes;

    class AuthController {
        public function autenticarUsuario() {
            session_start();
            $usuarioDAO = new UsuarioDAO();
            $clienteDAO = new ClienteDAO();
            $rolDAO = new RolDAO();
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

            // Guardamos los datos
            $correo = $input["correo"];
            $clave = md5($input["clave"]);

            $usuario = $usuarioDAO->AutenticarUsuario($correo, $clave);
            $cliente = $clienteDAO->autenticarCliente($correo, $clave);

            // Si el usuario se encuentra, ya sea admin o cliente
            if($usuario !== null || $cliente !== null) {
                $idRol = $usuario !== null 
                    ? $usuario["idRol"] 
                    : $cliente["idRol"];
                $rol = $rolDAO->obtenerPorId($idRol);

                if($rol === null) {
                    echo json_encode(["error" => "Rol no encontrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $rolObjeto = new Rol(
                    $rol["id"],
                    $rol["nombre"]
                );

                if($usuario !== null) {
                    $usuarioAutenticado = new Usuario(
                        $usuario["id"],
                        $usuario["nombre"],
                        $usuario["apellido"],
                        $usuario["correo"],
                        "",
                        $rolObjeto
                    );
                }
                else {
                    $usuarioAutenticado = new Usuario(
                        $cliente["id"],
                        $cliente["nombre"],
                        $cliente["apellido"],
                        $cliente["correo"],
                        "",
                        $rolObjeto
                    );
                }
                
                $_SESSION["usuario"] = $usuarioAutenticado;
                $respuesta = [
                    "mensaje" => "Usuario autenticado correctamente",
                    "usuario" => [
                        "id" => $usuarioAutenticado->getIdPersona(),
                        "nombre" => $usuarioAutenticado->getNombre(),
                        "apellido" => $usuarioAutenticado->getApellido(),
                        "rol" => $usuarioAutenticado->getRol()->getNombre()
                    ]
                ];

                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Si no existe
            session_unset();
            session_destroy();
            echo json_encode(["error" => "Usuario o contraseña incorrectos"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    if($_GET["accion"] && $_GET["accion"] === "autenticar") {
        $controlador = new AuthController();
        $controlador->autenticarUsuario();
    }
?>