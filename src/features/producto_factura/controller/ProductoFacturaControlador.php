<?php
    require_once "../../producto_factura/dao/ProductoFacturaDAO.php";
    header('Content-Type: application/json; charset=utf-8');

    use dao\ProductoFacturaDAO;
use model\ProductoFactura;

    class ProductoFacturaControlador {
        public function listarDetallesPorIdFactura() {
            $productoFacturaDAO = new ProductoFacturaDAO();

            if(!isset($_GET["idFactura"])) {
                echo json_encode(['error' => 'ID de la factura no proporcionado'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $idFactura = $_GET['idFactura'];
            $detallesFactura = $productoFacturaDAO->obtenerPorIdFactura($idFactura);

            if($detallesFactura === null) {
                echo json_encode(['error' => 'Error al listar por el Id de la factura'], JSON_UNESCAPED_UNICODE);
                exit;
            };

            echo json_encode($detallesFactura, JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function getAll () {
            $productoFacturaDAO = new ProductoFacturaDAO();

            $cantidadFacturas = $productoFacturaDAO->getAll();

            if($cantidadFacturas === null) {
                echo json_encode(['error' => 'Error al encontrar facturas'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            echo json_encode($cantidadFacturas, JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    if ($_GET['accion'] && $_GET['accion'] === 'listarFacturas') {
        $controlador = new ProductoFacturaControlador();
        $controlador->getAll();
    }
    
    if($_GET['accion'] && $_GET['accion'] === 'listarPorIdFactura') {
        $controlador = new ProductoFacturaControlador();
        $controlador->listarDetallesPorIdFactura();
    }
?>