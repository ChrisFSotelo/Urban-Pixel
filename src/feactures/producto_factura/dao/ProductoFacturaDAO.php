<?php
    require_once "../../../../config/Conexion.php";
    require_once "../../factura/model/Factura.php";
    require_once "../../factura/dao/FacturaDAO.php";
    require_once "../../productos/model/Producto.php";
    require_once "../../productos/dao/ProductoDAO.php";

    class ProductoFacturaDAO {
        private Conexion $conexion;
        private FacturaDAO $facturaDAO;
        private ProductoDAO $productoDAO;

        // Se instancian los objetos
        public function __construct() {
            $this->conexion = new Conexion();
            $this->facturaDAO = new FacturaDAO();
            $this->productoDAO = new ProductoDAO();
        }

        // Obtener los detalles de una factura por id
        public function obtenerPorIdFactura(int $idFactura): array | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM producto_factura WHERE idFactura = $idFactura";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $detallesFactura[] = [];

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener los detalles de la factura \n");
                return null;
            }
            
            while($fila = $resultado->fetch_object()) { // Si se encuentran los detalles
                $factura = $this->facturaDAO->obtenerPorId((int) $fila->idFactura); // Obtenemos la factura
                $producto = $this->productoDAO->obtenerPorId((int) $fila->idProducto); // Obtenemos el producto

                $detallesFactura[] = new ProductoFactura(
                    $factura,
                    $producto,
                    (int) $fila->cantidad,
                    (int) $fila->precioVenta
                );
            }

            $this->conexion->cerrarConexion();
            return $detallesFactura;
        }

        // Inserta los detalles de una factura
        public function insertar(array $detallesFactura): array | null {
            $this->conexion->abrirConexion();

            foreach($detallesFactura as $detalle) {
                $idFactura = $detalle->getFactura()->getId();
                $idProducto = $detalle->getProducto()->getId();
                $cantidad = $detalle->getCantidad();
                $precioVenta = $detalle->getPrecioVenta();

                $sql = "INSERT INTO producto_factura(idFactura, idProducto, cantidad, precioVenta)
                    VALUES($idFactura, $idProducto, $cantidad, $precioVenta)";

                $resultado = $this->conexion->ejecutarConsulta($sql);

                if(!$resultado) { // Si hubo un error
                    $this->conexion->cerrarConexion();
                    echo("Hubo un fallo al agregar los detalles de la factura \n");
                    return null;
                }
            }

            // Si todo salio bien
            $this->conexion->cerrarConexion();
            return $detallesFactura;
        }

        // Elimina los detalles de una factura en la BD
        public function eliminar(int $idFactura): array | null {
            $detallesFactura = $this->obtenerPorIdFactura($idFactura);

            if($detallesFactura !== null) { // Si se encuentra la factura
                $this->conexion->abrirConexion();
                $sql = "DELETE FROM producto_factura WHERE idFactura = $idFactura";
                $resultado = $this->conexion->ejecutarConsulta($sql);
                $this->conexion->cerrarConexion();

                if($resultado) // Si todo salio bien
                    return $detallesFactura;

                // Si hubo un error
                echo("Hubo un fallo al eliminar los detalles de la factura \n");
            }

            return null;
        }
    }
?>