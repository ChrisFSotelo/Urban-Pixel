<?php
    require_once "../model/ProductoFactura.php";
    require_once "../dao/ProductoFacturaDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_POST["accion"])) {
        $accion = $_REQUEST["accion"];
        $productoFacturaDAO = new ProductoFacturaDAO();
        $datos = null;

        switch($accion) {
            case "listarPorFactura": {
                $idFactura = $_POST["idFactura"];
                $detallesFactura = $productoFacturaDAO->obtenerPorIdFactura($idFactura);

                if($detallesFactura === null) {
                    $datos = ["error" => "Error al listar los detalles de la factura"];
                    break;
                }

                $datos = [
                    "mensaje" => "Detalles listados correctamente",
                    "detalles" => generarJsonDeUnArray($detallesFactura)
                ];

                break;
            }
        }
    }
    else
        header("Location: ../../../../");

    function generarJsonDeUnArray(array $detallesFactura) {
        return array_map(function($detalle) {
            return [
                'factura' => [
                    'id' => $detalle->getFactura()->getId(),
                    'fecha' => $detalle->getFactura()->getFecha(),
                    'total' => $detalle->getFactura()->getTotal(),
                    'cliente' => [
                        'id' => $detalle->getFactura()->getCliente()->getId(),
                        'nombre' => $detalle->getFactura()->getCliente()->getNombre(),
                    ],
                ],
                'producto' => [
                    'id' => $detalle->getFactura()->getProducto()->getId(),
                    'nombre' => $detalle->getFactura()->getProducto()->getNombre(),
                    'precio' => $detalle->getFactura()->getProducto()->getPrecio(),
                ],
                'cantidad' => $detalle->getCantidad(),
                'precioVenta' => $detalle->getPrecioVenta()
            ];
        }, $detallesFactura);
    }
?>