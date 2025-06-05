<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/ProductDAO.php";

class ListarProductosController
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

            require __DIR__ . '/listar_producto.php';
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


// $accion = $_GET['a'] ?? null;
// if ($accion === 'listar') {
//     listarProductController();
// }

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new ListarProductosController();
    $controller->listarProductController();
}