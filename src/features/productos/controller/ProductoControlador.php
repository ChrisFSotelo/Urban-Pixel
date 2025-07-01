<?php
require_once "../../productos/model/Producto.php";
require_once "../../productos/dao/ProductoDAO.php";
require_once "../../categorias/dao/CategoriaDAO.php";
require_once "../../categorias/model/Categoria.php";
header('Content-Type: application/json; charset=utf-8');

use dao\ProductoDAO;
use model\Producto;
use dao\CategoriaDAO;
use model\Categoria;

class ProductoControlador{
    public function listar() {
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->listar();

        if($productos == null)
            $respuesta = ["error" => "Error al listar los productos"];
        else {
            $respuesta = $productos;

            if(!empty($respuesta)) {
                for($i = 0; $i < count($respuesta); $i++) {
                    $respuesta[$i]["no"] = $i + 1;
                    $estado = $respuesta [$i] ["estado"] == 1 ? "Activo" : "Inactivo";
                    $respuesta[$i] ["estado"] = $estado;
                    $respuesta[$i]["editar"] =
                        '<button 
                            class="btn btn-primary" 
                            type="button" 
                            title="Editar" 
                            onclick="obtenerProductoInfo('.$respuesta[$i]["id"].')"
                        >
                            <i class="fa-solid fa-pencil"></i>
                        </button>';
                    $respuesta[$i]["eliminar"] = 
                        '<button 
                            class="btn btn-danger" 
                            type="button" 
                            title="Eliminar"
                            onclick="confirmarEliminacionProducto('.$respuesta[$i]["id"].')"
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
        $productoDAO = new ProductoDAO();

        // Validar que se reciba el ID por GET
        if(empty($_GET["id"])) {
            $respuesta = ["error" => "ID no proporcionado"];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id = $_GET["id"];
        $producto = $productoDAO->obtenerPorId($id);

        if ($producto === null)
            $respuesta = ["error" => "No se econtro el producto"];
        else
            $respuesta = $producto;

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function RegistrarProducto() {
        $productoDAO = new ProductoDAO();
        $categoriaDAO = new CategoriaDAO();
        $categoria = $categoriaDAO->obtenerPorId($_POST["categoria"]);
        $estado = 1;
        if (
            empty($_POST["nombre"]) ||
            empty($_POST["cantidad"]) ||
            empty($_POST["precio"]) ||
            empty($_POST["descripcion"]) ||
            empty($_POST["categoria"])
        ) {
            echo json_encode(["error" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if($categoria === null) {
            echo json_encode(["error" => "Error al encontrar la categoría"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    
        $categoriaObjeto = new Categoria(
            $categoria["id"],
            $categoria["nombre"]
        );
        $producto = new Producto(
            0,
            $_POST["nombre"],
            $_POST["cantidad"],
            $_POST["precio"],
            $categoriaObjeto,
            $estado,
            $_POST["descripcion"]
        );
    
        $resultado = $productoDAO->RegistrarProducto($producto);
    
        if ($resultado === null)
            $respuesta = ["error" => "Error al registrar el producto"];
        else {
            $respuesta = [
                "mensaje" => "Producto registrado correctamente",
                "producto" => [
                    "nombre" => $producto->getNombre(),
                    "categoria" => $producto->getCategoria()->getNombre()
                ]
            ];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function actualizarProducto() {
        $productoDAO = new ProductoDAO();
        $categoriaDAO = new CategoriaDAO();
        $categoria = $categoriaDAO->obtenerPorId($_POST["categoria"]);

        if(
            empty($_POST["id"]) ||
            empty($_POST["nombre"]) ||
            empty($_POST["cantidad"]) ||
            empty($_POST["precio"]) ||
            empty($_POST["descripcion"]) ||
            empty($_POST["categoria"])
        ) {
            echo json_encode(["error" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        if($categoria === null) {
            echo json_encode(["error" => "Error al encontrar la categoría"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $categoriaObjeto = new Categoria(
            $categoria["id"],
            $categoria["nombre"]
        );
        $producto = new Producto(
            $_POST["id"],
            $_POST["nombre"],
            $_POST["cantidad"],
            $_POST["precio"],
            $categoriaObjeto,
            0, // Estado activo por defecto
            $_POST["descripcion"]
        );

        $resultado = $productoDAO->actualizarProducto($producto);

        if ($resultado === null)
            $respuesta = ["error" => "Error al actualizar el producto"];
        else {
            $respuesta = [
                "mensaje" => "Producto actualizado correctamente",
                "producto" => [
                    "id" => $producto->getId(),
                    "nombre" => $producto->getNombre(),
                    "categoria" => $producto->getCategoria()->getNombre()
                ]
            ];
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function ActualizarEstado(){
        if(empty($_POST["id"])|| !isset($_POST["estado"])){
            echo json_encode(["error" => "Faltan parámetros obligatorios"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $id =$_POST["id"];
        $estadoActual = $_POST["estado"];
        $nuevoEstado = $estadoActual == 1 ? 0 : 1;

        $productoDAO= new ProductoDAO();
        $productoActual = $productoDAO->obtenerPorId($id);

        if($productoActual===null){
            echo json_encode(["error" => "Producto no encontrado"], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $resultado = $productoDAO->ActualizarEstado($id, $nuevoEstado);

        if($resultado){
            $respuesta = [
                "mensaje" => "Estado actualizado correctamente",
                "producto" =>[
                    "id" => $id,
                    "estado" => $nuevoEstado
                ]
            ];
        }
        else
            $respuesta = ["error" => "No se pudo actualizar el producto"];

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function listarPublico() {
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->listar();

        if ($productos == null) {
            echo json_encode(["error" => "No se encontraron productos"], JSON_UNESCAPED_UNICODE);
        } else {
            // Filtramos solo los campos necesarios
            $respuesta = array_map(function($producto) {
                return [
                    "id" => $producto["id"],
                    "nombre" => $producto["nombre"],
                    "precio" => $producto["precio"],
                ];
            }, $productos);

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        }

        exit;
    }

}

// ✅ Este bloque es el que activa la ejecución del método
if(isset($_GET["accion"]) && $_GET["accion"] === "listar") {
    $controlador = new ProductoControlador();
    $controlador->listar();
}

if (isset($_GET["accion"]) && $_GET["accion"] === "obtenerPorId") {
    $controlador = new ProductoControlador();
    $controlador->obtenerPorId();
}

if (isset($_GET["accion"]) && $_GET["accion"] === "registrar_producto") {
    $controlador = new ProductoControlador();
    $controlador->RegistrarProducto();
}

if(isset($_GET["accion"]) && $_GET["accion"] === "listarPublico") {
    $controlador = new ProductoControlador();
    $controlador->listarPublico();
}

if (isset($_GET["accion"]) && $_GET["accion"] === "actualizar") {
    $controlador = new ProductoControlador();
    $controlador->actualizarProducto();
}
if (isset($_GET["accion"]) && $_GET["accion"] === "actualizarEstado") {
    $controlador = new ProductoControlador();
    $controlador->ActualizarEstado();
}


