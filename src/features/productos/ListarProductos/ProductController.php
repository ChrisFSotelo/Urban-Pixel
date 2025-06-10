<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/ProductDAO.php";

class ProductosController
{
    public function listarProductController()
    {
        try {
            $dao = new ProductDAO();
            $productos = $dao->listar();

            // header('Content-Type: application/json; charset=utf-8');
            // echo json_encode([
            //     'status' => 'success',
            //     'data' => $productos,
            // ]);

            require __DIR__ . '/View.php';
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function buscarPorNombreController($nombre)
    {
        try {
            $dao = new ProductDAO();
            $productos = $dao->buscarPorNombre($nombre);

            ob_start();
            require __DIR__ . '/views/Resultados.php';
            $html = ob_get_clean();

            echo $html;
            exit;
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }      
    }
}


// $accion = $_GET['a'] ?? null;
// if ($accion === 'listar') {
//     listarProductController();
// }

$controller = new ProductosController();

if (isset($_GET['a']) && $_GET['a'] === 'buscar') {
    $controller->buscarPorNombreController($_GET['query'] ?? '');
    exit;
}

$controller->listarProductController();
