<?php
    require_once "../../clientes/model/Cliente.php";
    require_once "../../clientes/dao/ClienteDAO.php";
    require_once "../model/Factura";
    require_once "../dao/FacturaDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $clienteDAO = new ClienteDAO();
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
                    "roles" => generarJsonDeUnArray($facturas)
                ];

                break;
            };

            case "agregar": {
                // FALTA AGREGAR EN LA TABLA PRODUCTO_FACTURA!!

                // Obtenemos el objeto desde su DAO
                $cliente = $clienteDAO->obtenerPorId((int) $_POST["idCliente"]);

                // Validamos que exista
                if($cliente === null) {
                    $datos = ["error" => "Cliente no encontrado"];
                    break;
                }
                
                // Creamos el objeto 'Factura'
                $factura = new Factura(
                    0, 
                    new DateTime(date("Y-m-d")), // Obtenemos fecha actual con formato AA-MM-DD
                    new DateTime(date("H:i:s")), // Obtenemos hora actual con formato HH:MM:SS
                    (int) $_POST["subtotal"],
                    (int) $_POST["iva"],
                    (int) $_POST["total"],
                    $cliente, 
                    $_POST["ciudad"],
                    $_POST["direccion"],
                );

                // Insertamos y validamos
                if($facturaDAO->insertar($factura) === null) {
                    $datos = ["error" => "Error al insertar la factura"];
                    break;
                }

                $hora = $factura->getHora()->format("H:i:s");
                $fecha = $factura->getFecha()->format("Y-m-d");
                $nuevaFactura = $facturaDAO->obtenerPorIdClienteHoraFecha($factura->getCliente()->getId(), $hora, $fecha);
                $datos = [
                    "mensaje" => "Factura agregada correctamente",
                    "rol" => generarJsonDeUnObjeto($nuevaFactura)
                ];
                
                break;
            };

            case "eliminar": {
                // FALTA ELIMINAR EN LA TABLA PRODUCTO_FACTURA!!

                $id = (int) $_POST["id"];

                // Eliminamos y validamos
                if($facturaDAO->eliminar($id) === null) {
                    $datos = ["error" => "Error al eliminar la factura"];
                    break;
                }

                $datos = [
                    "mensaje" => "Factura con id = ". $id ." eliminada correctamente"
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