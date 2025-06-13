<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../model/Producto.php';
require_once __DIR__ . '/../dao/ProductoDAO.php';
require_once '../../categorias/dao/CategoriaDAO.php';
require_once '../../categorias/model/Categoria.php';

use model\Producto;
use dao\ProductoDAO;
header('Content-Type: application/json; charset=utf-8');
class ProductoControlador{
    public function listar() {
        $productoDAO = new ProductoDAO();
        $productos = $productoDAO->listar();

        $respuesta = [];

        if (empty($productos)) {
            $respuesta = ["error" => "No se encontraron productos"];
        } else {
            foreach ($productos as $index => $producto) {
                $respuesta[] = [
                    "no" => $index + 1,
                    "id" => $producto->getId(),
                    "nombre" => $producto->getNombre(),
                    "cantidad" => $producto->getCantidad(),
                    "precio" => $producto->getPrecio(),
                    "editar" =>
                        '<button 
                        class="btn btn-primary" 
                        type="button" 
                        title="Editar" 
                        onclick="obtenerClienteInfo('.$producto->getId().')"
                    >
                        <i class="fa-solid fa-pencil"></i>
                    </button>',
                    "eliminar" =>
                        '<button 
                        class="btn btn-danger" 
                        type="button" 
                        title="Eliminar"
                        onclick="confirmarEliminacion('.$producto->getId().')"
                    >
                        <i class="fa-solid fa-times"></i>
                    </button>',
                ];
            }
        }

        echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function RegistrarProducto() {
        $productoDAO = new ProductoDAO();
        $categoriaDAO = new CategoriaDAO();
        $categorias = $categoriaDAO->obtenerPorId($_POST["categoria"]);

        if (
            empty($_POST["nombre"]) ||
            empty($_POST["cantidad"]) ||
            empty($_POST["precio"]) ||
            empty($_POST["categoria"])
        ) {
            echo json_encode(["error" => "Todos los campos son obligatorios"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    
        $producto = new Producto(
            0,
            $_POST["nombre"],
            $_POST["cantidad"],
            $_POST["precio"],
            $categorias
        );
    
        
        $resultado = $productoDAO->RegistrarProducto($producto);
    
        if ($resultado === null) {
            echo json_encode(["error" => "Error al registrar el producto"], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(["mensaje" => "Producto registrado exitosamente"], JSON_UNESCAPED_UNICODE);
        }
    
        exit;
    }
}

// ✅ Este bloque es el que activa la ejecución del método
if(isset($_GET["accion"]) && $_GET["accion"] === "listar") {
    $controlador = new ProductoControlador();
    $controlador->listar();
}

if (isset($_GET["accion"]) && $_GET["accion"] === "registrar_producto") {
    $controlador = new ProductoControlador();
    $controlador->RegistrarProducto();
}

