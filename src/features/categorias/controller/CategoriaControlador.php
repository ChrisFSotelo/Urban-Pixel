<?php 
    require_once "../model/Categoria.php";
    require_once "../dao/CategoriaDAO.php";
    header('Content-Type: application/json; charset=utf-8');

    use dao\CategoriaDAO;
    use model\Categoria;

    class CategoriaControlador {
        function listarCategorias(): array {
            $categoriaDAO = new CategoriaDAO();
            $categorias = $categoriaDAO->listar();

            if($categorias === null)
                $respuesta = ["error" => "No se encontraron las categorias"];
            else {
                $respuesta = $categorias;

                if(!empty($categorias)) {
                    for($i = 0; $i < count($respuesta); $i++) {
                        $respuesta[$i]["no"] = $i + 1;
                        $respuesta[$i]["editar"] = 
                            '<button 
                                class="btn btn-primary" 
                                type="button" 
                                title="Editar" 
                                onclick="obtenerCategoriaInfo('.$respuesta[$i]["id"].')"
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
            $categoriaDAO = new CategoriaDAO();

            // Validar que se reciba el ID por GET
            if(empty($_GET["id"])) {
                $respuesta = ["error" => "ID no proporcionado"];
                echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
                exit;
            }

            $id = $_GET["id"];
            $categoria = $categoriaDAO->obtenerPorId($id);

            if ($categoria === null)
                $respuesta = ["error" => "No se econtro el producto"];
            else
                $respuesta = $categoria;

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function registar() {
            $categoriaDAO = new CategoriaDAO();

            if(empty($_POST["nombre"])) {
                echo json_encode(["error" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $categoria = new Categoria(
                0,
                $_POST["nombre"]
            );
        
            $resultado = $categoriaDAO->insertar($categoria);
        
            if ($resultado === null)
                $respuesta = ["error" => "Error al registrar la categoria"];
            else {
                $respuesta = [
                    "mensaje" => "Categoria registrada correctamente",
                    "categoria" => [
                        "nombre" => $categoria->getNombre()
                    ]
                ];
            }

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function actualizar() {
            $categoriaDAO = new CategoriaDAO();

            if(empty($_POST["id"]) || empty($_POST["nombre"])) {
                echo json_encode(["error" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $categoria = new Categoria(
                $_POST["id"],
                $_POST["nombre"]
            );
        
            $resultado = $categoriaDAO->actualizar($categoria);
        
            if ($resultado === null)
                $respuesta = ["error" => "Error al actualizar la categoria"];
            else {
                $respuesta = [
                    "mensaje" => "Categoria actualizada correctamente",
                    "categoria" => [
                        "id" => $categoria->getId(),
                        "nombre" => $categoria->getNombre()
                    ]
                ];
            }

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function eliminar() {
            $categoriaDAO = new CategoriaDAO();

            if(empty($_GET["id"])) {
                echo json_encode(["error" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE);
                exit;
            }
        
            $id = $_GET["id"];
            $resultado = $categoriaDAO->eliminar($id);
        
            if ($resultado === null)
                $respuesta = ["error" => "La categoría es usada en algún producto"];
            else
                $respuesta = ["mensaje" => "Categoría eliminada correctamente"];

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    // ✅ Este bloque es el que activa la ejecución del método
    if(isset($_GET["accion"]) && $_GET["accion"] === "listar") {
        $controlador = new CategoriaControlador();
        $controlador->listarCategorias();
    }

    if(isset($_GET["accion"]) && $_GET["accion"] === "obtenerPorId") {
        $controlador = new CategoriaControlador();
        $controlador->obtenerPorId();
    }

    if(isset($_GET["accion"]) && $_GET["accion"] === "agregar") {
        $controlador = new CategoriaControlador();
        $controlador->registar();
    }

    if(isset($_GET["accion"]) && $_GET["accion"] === "actualizar") {
        $controlador = new CategoriaControlador();
        $controlador->actualizar();
    }

    if(isset($_GET["accion"]) && $_GET["accion"] === "eliminar") {
        $controlador = new CategoriaControlador();
        $controlador->eliminar();
    }
?>