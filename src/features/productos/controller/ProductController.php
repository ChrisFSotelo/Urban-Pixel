<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../dao/ProductDAO.php";

function listarProductController()
{
    try {
        $productoDAO = new ProductDAO();
        $productos = $productoDAO->listar();

        require __DIR__ . "/../views/listar_producto.php";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

$accion = $_GET['a'] ?? null;
if ($accion === 'listar') {
    listarProductController();
} else {
    echo "Acción no especificada. Añade ?a=listar a la URL.";
}
