<?php
    use dao\UsuarioDAO;

    require_once "Categoria.php";
    require_once "CategoriaDAO.php";
    require_once "Producto.php";
    require_once "ProductoDAO.php";
    require_once "Usuario.php";
    require_once "UsuarioDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $productoDAO = new ProductoDAO();
        $categoriaDAO = new CategoriaDAO();
        $adminDAO = new UsuarioDAO();
        $datos = null;

        switch ($accion) {
            case "agregar": {
                // Obtenemos los objetos reales desde sus DAOs
                $categoria = $categoriaDAO->obtenerPorId((int) $_POST["idCategoria"]);
                $administrador = $adminDAO->obtenerPorId((int) $_POST["idAdministrador"]);

                // Validamos que existan
                if($categoria === null || $administrador === null) {
                    $datos = ["error" => "Categoría o administrador no encontrados"];
                    break;
                }

                // Creamos el objeto 'Producto'
                $producto = new Producto(
                    0, 
                    $_POST["nombre"],
                    (int) $_POST["cantidad"],
                    (int) $_POST["precio"],
                    $categoria,
                    $administrador
                );

                // Evitamos duplicados por nombre
                if($productoDAO->obtenerPorNombre($producto->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe un producto con ese nombre"];
                    break;
                }

                // Insertamos y validamos
                if($productoDAO->insertar($producto) === null) {
                    $datos = ["error" => "Error al insertar el producto"];
                    break;
                }

                $datos = [
                    "mensaje" => "Producto agregado correctamente",
                    "producto" => $productoDAO->obtenerPorNombre($producto->getNombre())
                ];

                break;
            }
        }

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    else 
        header("Location: index.php");
?>