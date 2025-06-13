<?php 
    require_once "../model/Categoria.php";
    require_once "../dao/CategoriaDAO.php";
    header('Content-Type: application/json; charset=utf-8');

    use dao\CategoriaDAO;
    
    class CategoriaControlador {
        function listarCategorias(): array {
            $categoriaDAO = new CategoriaDAO();
            $categorias = $categoriaDAO->listar();

            if($categorias === null)
                $respuesta = ["error" => "No se encontraron las categorias"];
            else
                $respuesta = $categorias;

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

// ✅ Este bloque es el que activa la ejecución del método
if(isset($_GET["accion"]) && $_GET["accion"] === "listar") {
    $controlador = new CategoriaControlador();
    $controlador->listarCategorias();
}
?>