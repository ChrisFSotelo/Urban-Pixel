<?php
    require_once "../../clientes/model/Cliente.php";
    require_once "../../clientes/dao/ClienteDAO.php";
    require_once "../../producto_factura/model/ProductoFactura.php";
    require_once "../../producto_factura/dao/ProductoFacturaDAO.php";
    require_once "../model/Factura";
    require_once "../dao/FacturaDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $clienteDAO = new ClienteDAO();
        $productoFacturaDAO = new ProductoFacturaDAO();
        $facturaDAO = new FacturaDAO();
        $datos = null;

        switch($accion) {
            case "listar": {
                $facturas = $facturaDAO->listar();

                if($facturas === null) {
                    $datos = ["error" => "Error al listar las facturas"];
                    break;
                }

                $datos = [
                    "mensaje" => "Facturas listadas correctamente",
                    "facturas" => generarJsonDeUnArray($facturas)
                ];

                break;
            };

            case "agregar": {
                // Obtenemos el objeto desde su DAO
                $cliente = $clienteDAO->obtenerPorId((int) $_POST["idCliente"]);

                // Validamos que exista
                if($cliente === null) {
                    $datos = ["error" => "Cliente no encontrado"];
                    break;
                }
                
                $productos = $_POST["productos"]; // Tomamos los productos seleccionados
                $cantidades = $_POST["cantidades"]; // Tomamos las cantidad de cada producto seleccionado
                $subtotal = 0;

                for($i = 0; $i < count($productos); $i++) // Obtenemos el subtotal
                    $subtotal += $productos[$i]->getPrecio() * ((int) $cantidades[$i]);

                $iva = 0.19; // Valor del iva
                $total = $subtotal + ($subtotal * $iva); // Calculamos el total de la venta

                // Creamos el objeto 'Factura'
                $factura = new Factura(
                    0, 
                    new DateTime(date("Y-m-d")), // Obtenemos fecha actual con formato AA-MM-DD
                    new DateTime(date("H:i:s")), // Obtenemos hora actual con formato HH:MM:SS
                    $subtotal,
                    $iva,
                    $total,
                    $cliente, 
                    $_POST["ciudad"],
                    $_POST["direccion"],
                );

                // Insertamos la factura y validamos
                if($facturaDAO->insertar($factura) === null) {
                    $datos = ["error" => "Error al insertar la factura"];
                    break;
                }

                $fecha = $factura->getFecha()->format("Y-m-d");
                $hora = $factura->getHora()->format("H:i:s");
                $nuevaFactura = $facturaDAO->obtenerPorIdClienteHoraFecha($cliente->getId(), $hora, $fecha);
                $detallesFactura[] = [];

                for($i = 0; $i < count($productos); $i++) {
                    $detallesFactura[] = new ProductoFactura(
                        $nuevaFactura,
                        $productos[$i],
                        $cantidades[$i],
                        $productos[$i]->getPrecio() * ((int) $cantidades[$i])
                    );   
                }

                // Insertamos los detalles de la factura y validamos
                if($productoFacturaDAO->insertar($detallesFactura) === null) {
                    $datos = ["error" => "Error al insertar los detalles de la factura"];
                    break;
                }

                $datos = [
                    "mensaje" => "Factura y detalles agregados correctamente",
                    "factura" => generarJsonDeUnObjeto($nuevaFactura)
                ];
                
                break;
            };

            case "eliminar": {
                $id = (int) $_POST["id"];

                // Eliminamos primero los detalles de la factura y validamos
                if($productoFacturaDAO->eliminar($id) === null) {
                    $datos = ["error" => "Error al eliminar los detalles de la factura"];
                    break;
                }

                // Eliminamos la factura y validamos
                if($facturaDAO->eliminar($id) === null) {
                    $datos = ["error" => "Error al eliminar la factura"];
                    break;
                }

                $datos = [
                    "mensaje" => "La factura ". $id ." y sus detalles fueron eliminados correctamente"
                ];

                break;
            }
        }

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    else 
        header("Location: ../../../../");

    function generarJsonDeUnArray(array $facturas) {
        return array_map(function($factura) {
            return [
                'id' => $factura->getId(),
                'fecha' => $factura->getFecha(),
                'hora' => $factura->getHora(),
                'subtotal' => $factura->getSubtotal(),
                'iva' => $factura->getIva(),
                'total' => $factura->getTotal(),
                'cliente' => [
                    'id' => $factura->getCliente()->getId(),
                    'nombre' => $factura->getCliente()->getNombre(),
                ],
                'ciudad' => $factura->getCiudad(),
                'direccion' => $factura->getDireccion()
            ];
        }, $facturas);
    }

    function generarJsonDeUnObjeto(Factura $factura) {
        return [
            'id' => $factura->getId(),
            'fecha' => $factura->getFecha(),
            'hora' => $factura->getHora(),
            'subtotal' => $factura->getSubtotal(),
            'iva' => $factura->getIva(),
            'total' => $factura->getTotal(),
            'cliente' => [
                'id' => $factura->getCliente()->getId(),
                'nombre' => $factura->getCliente()->getNombre(),
            ],
            'ciudad' => $factura->getCiudad(),
            'direccion' => $factura->getDireccion()
        ];
    }
?>