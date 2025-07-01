<?php
    require_once "../../users/dao/ClienteDAO.php";
    require_once "../../productos/dao/ProductoDAO.php";
    require_once "../../producto_factura/model/ProductoFactura.php";
    require_once "../../producto_factura/dao/ProductoFacturaDAO.php";
    require_once "../model/Factura.php";
    require_once "../dao/FacturaDAO.php";
    header('Content-Type: application/json; charset=utf-8');

    use dao\ClienteDAO;
    use dao\FacturaDAO;
    use dao\ProductoDAO;
    use dao\ProductoFacturaDAO;
    use model\Factura;
    use model\ProductoFactura;

    class FacturaControlador {
        public function listarFacturas() {
            $facturaDAO = new FacturaDAO();
            $facturas = $facturaDAO->listar();

            if($facturas === null) {
                echo json_encode(['error' => 'Error al listar facturas'], JSON_UNESCAPED_UNICODE);
                exit;
            }
            else {
                $respuesta = $facturas;

                if(!empty($resultado)) {
                    for($i = 0; $i < count($resultado); $i++) {
                        $respuesta[$i]["no"] = $i + 1;
                        $respuesta[$i]["info"] = 
                            '<button 
                                class="btn btn-primary" 
                                type="button" 
                                title="Información" 
                                onclick="obtenerFacturaInfo('.$respuesta[$i]["id"].')"
                            >
                                <i class="fa-solid fa-eye"></i>
                            </button>';
                    }
                }
            }

            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function agregarFactura() {
            $clienteDAO = new ClienteDAO();
            $facturaDAO = new FacturaDAO();
            $productoDAO = new ProductoDAO();
            $productoFacturaDAO = new ProductoFacturaDAO();
            date_default_timezone_set('America/Bogota'); // Configuramos la zona horaria

            // Validamos los datos enviados
            if(
                !isset($_POST['idCliente']) || !isset($_POST['ciudad']) ||
                !isset($_POST['direccion']) || !isset($_POST['cantidades']) ||
                !isset($_POST['idsProductos'])
            ) {
                echo json_encode(['error' => 'Todos los datos son obligatorios'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Obtenemos el objeto desde su DAO
            $cliente = $clienteDAO->obtenerPorId($_POST["idCliente"]);

            // Validamos que exista
            if($cliente === null) {
                echo json_encode(['error' => 'Cliente no encontrado'], JSON_UNESCAPED_UNICODE);
                exit;
            }
            
            $idsProductos = $_POST["idsProductos"]; // Tomamos los productos seleccionados
            $cantidades = $_POST["cantidades"]; // Tomamos las cantidad de cada producto seleccionado
            $subtotal = 0;

            for($i = 0; $i < count($idsProductos); $i++) { // Obtenemos el subtotal
                $producto = $productoDAO->obtenerPorId($idsProductos[$i]);

                if($producto === null) {
                    echo json_encode(['error' => 'Producto con ID '.$idsProductos[$i].' no encontrado'], JSON_UNESCAPED_UNICODE);
                    exit;
                }

                $subtotal += (((int) $producto['precio']) * ((int) $cantidades[$i]));
            }

            $iva = 0.19; // Valor del iva
            $total = $subtotal + ($subtotal * $iva); // Calculamos el total de la venta

            // Creamos el objeto 'Factura'
            $facturaObjeto = new Factura(
                0, 
                date('Y-m-d'), // Obtenemos fecha actual con formato AA-MM-DD
                date('H:i:s'), // Obtenemos hora actual con formato HH:MM:SS
                $subtotal,
                $iva,
                $total,
                $_POST['idCliente'],
                $_POST["ciudad"],
                $_POST["direccion"]
            );

            // Insertamos la factura y validamos
            if($facturaDAO->insertar($facturaObjeto) === null) {
                echo json_encode(['error' => 'Error al agregar la factura'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $hora = $facturaObjeto->getHora(); // Obtenemos la hora
            $fecha = $facturaObjeto->getFecha(); // Obtenemos la fecha
            $nuevaFactura = $facturaDAO->obtenerPorIdClienteHoraFecha($_POST['idCliente'], $hora, $fecha); // Obtenemos la factura recien agregada
            $detallesFactura = [];

            for($i = 0; $i < count($idsProductos); $i++) {
                $producto = $productoDAO->obtenerPorId($idsProductos[$i]);

                $detallesFactura[] = new ProductoFactura(
                    (int) $nuevaFactura['id'],
                    (int) $producto['id'],
                    (int) $cantidades[$i],
                    ((int) $producto['precio']) * ((int) $cantidades[$i])
                );
            }

            // Insertamos los detalles de la factura y validamos
            if($productoFacturaDAO->insertar($detallesFactura) === null) {
                echo json_encode(["error" => "Error al insertar los detalles de la factura"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $respuesta = [
                "mensaje" => "Factura y detalles agregados correctamente",
                "factura" => [
                    'id' => $nuevaFactura['id'],
                    'fecha' => $nuevaFactura['fecha'],
                    'hora' => $nuevaFactura['hora'],
                    'total' => $nuevaFactura['total']
                ]
            ];
            echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
            exit;
        }

        public function eliminarFacturaYDetalles() {
            $facturaDAO = new FacturaDAO();
            $productoFacturaDAO = new ProductoFacturaDAO();

            if(!isset($_GET['id'])) {
                echo json_encode(['error' => 'Todos los datos son obligatorios'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $id = (int) $_GET['id'];

            // Buscamos la factura
            if($facturaDAO->obtenerPorId($id) === null) {
                echo json_encode(["error" => "Error al encontrar la factura"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Eliminamos primero los detalles de la factura y validamos
            if($productoFacturaDAO->eliminar($id) === null) {
                echo json_encode(["error" => "Error al eliminar los detalles de la factura"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Eliminamos la factura y validamos
            if($facturaDAO->eliminar($id) === null) {
                echo json_encode(["error" => "Error al eliminar la factura"], JSON_UNESCAPED_UNICODE);
                exit;
            }

            echo json_encode(["mensaje" => "Factura eliminada correctamente"], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }

    if($_GET['accion'] && $_GET['accion'] === 'listar') {
        $controlador = new FacturaControlador();
        $controlador->listarFacturas();
    }
    if($_GET['accion'] && $_GET['accion'] === 'agregar') {
        $controlador = new FacturaControlador();
        $controlador->agregarFactura();
    }
    if($_GET['accion'] && $_GET['accion'] === 'eliminar') {
        $controlador = new FacturaControlador();
        $controlador->eliminarFacturaYDetalles();
    }
?>