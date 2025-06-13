<?php
    require_once "../../users/model/Usuario.php";
    require_once "../../users/dao/UsuarioDAO.php";
    require_once "../../users/dao/ClienteDAO.php";
    require_once "../../roles/dao/RolDAO.php";
    header('Content-Type: application/json; charset=utf-8');

    use dao\ClienteDAO;
    use dao\RolDAO;
    use dao\UsuarioDAO;

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

            // Verificamos si el usuario es administrador o cliente
            if($usuario === null) { // Si no es admin
                $cliente = $clienteDAO->autenticarCliente($correo, $clave); // Verificamos si es cliente

                if($cliente === null) { // Si no es ninguna opcion
                    session_unset();
                    session_destroy();
                    echo json_encode(["error" => "Usuario o contraseña incorrectos"], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                // Si es cliente
                $rol = $rolDAO->obtenerPorId($cliente["idRol"]);

                if($rol === null) {
                    echo json_encode(["error" => "Rol no encontrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $rolObjeto = new Rol(
                    $rol["id"],
                    $rol["nombre"]
                );
                $usuarioAutenticado = new Usuario(
                    $cliente["id"],
                    $cliente["nombre"],
                    $cliente["apellido"],
                    $cliente["correo"],
                    "",
                    $rolObjeto
                );
                
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
            else { // Si es admin
                $rol = $rolDAO->obtenerPorId($usuario["idRol"]);

                if($rol === null) {
                    echo json_encode(["error" => "Rol no encontrado"], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $rolObjeto = new Rol(
                    $rol["id"],
                    $rol["nombre"]
                );
                $usuarioAutenticado = new Usuario(
                    $usuario["id"],
                    $usuario["nombre"],
                    $usuario["apellido"],
                    $usuario["correo"],
                    "",
                    $rolObjeto
                );
                
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
        }
    }

    if($_GET["accion"] && $_GET["accion"] === "autenticar") {
        $controlador = new AuthController();
        $controlador->autenticarUsuario();
    }
?>