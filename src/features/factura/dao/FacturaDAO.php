<?php

namespace dao;

require_once "../../../../config/Conexion.php";
require_once "../model/Factura.php";

use Conexion;
use model\Factura;

class FacturaDAO {
    private Conexion $conexion;

    // Se instancian los objetos
    public function __construct() {
        $this->conexion = new Conexion();
    }

    // Lista todas las facturas
    public function listarVentas(): array | null {
        $this->conexion->abrirConexion();
        $sql = "SELECT f.*, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS productos, CONCAT(c.nombre,' ', c.apellido) AS cliente
            FROM factura f
            JOIN producto_factura pf
            ON (f.id = pf.idFactura)
            JOIN cliente c
            ON (f.idCliente = c.id)
            JOIN producto p
            ON (pf.idProducto = p.id) 
            GROUP BY f.id
            ORDER BY f.id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $facturas = [];

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        while($fila = $resultado->fetch_assoc()) // Listamos las facturas
            $facturas[] = $fila;

        $this->conexion->cerrarConexion();
        return $facturas;
    }

    // Lista todas las facturas
    public function listarCompras($idCliente): array | null {
        $this->conexion->abrirConexion();
        $sql = "SELECT f.*, GROUP_CONCAT(p.nombre SEPARATOR ', ') AS productos
            FROM factura f
            JOIN producto_factura pf
            ON (f.id = pf.idFactura)
            JOIN cliente c
            ON (f.idCliente = c.id)
            JOIN producto p
            ON (pf.idProducto = p.id)
            WHERE c.id = $idCliente 
            GROUP BY f.id
            ORDER BY c.id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $facturas = [];

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        while($fila = $resultado->fetch_assoc()) // Listamos las facturas
            $facturas[] = $fila;

        $this->conexion->cerrarConexion();
        return $facturas;
    }


    // Obtener una factura por id
    public function obtenerPorId(int $id) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        if($fila = $resultado->fetch_assoc()) { // Si se encuentra la factura
            $this->conexion->cerrarConexion();
            return $fila;
        }

        // Si no se encuentra la factura
        $this->conexion->cerrarConexion();
        return null;
    }

    public function obtenerDetallesVenta(int $idVenta) {
        $this->conexion->abrirConexion();
        $sql = "SELECT f.*, CONCAT(c.nombre,' ', c.apellido) AS cliente, GROUP_CONCAT(p.nombre) AS productos, 
            GROUP_CONCAT(p.precio) AS preciosUnitarios, GROUP_CONCAT(pf.cantidad) AS cantidades, GROUP_CONCAT(pf.precioVenta) AS precioVentas
            FROM factura f
            JOIN producto_factura pf
            ON (f.id = pf.idFactura)
            JOIN cliente c
            ON (f.idCliente = c.id)
            JOIN producto p
            ON (pf.idProducto = p.id) 
            WHERE f.id = $idVenta
            GROUP BY f.id
            ORDER BY f.id ASC, p.id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        if($fila = $resultado->fetch_assoc()) { // Si se encuentran los detalles
            $this->conexion->cerrarConexion();
            return $fila;
        }

        // Si no se encuentra la factura
        $this->conexion->cerrarConexion();
        return null;
    }

    // Obtener facturas por cliente
    public function obtenerPorIdCliente(int $idCliente): array | null {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura WHERE idCliente = $idCliente";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $facturas = [];

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        while ($fila = $resultado->fetch_assoc()) // Listamos las facturas
            $facturas[] = $fila;

        $this->conexion->cerrarConexion();
        return $facturas;
    }

    public function obtenerPorIdClienteHoraFecha(int $idCliente, string $hora, string $fecha) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura WHERE (idCliente = $idCliente) AND (hora = '$hora') AND (fecha = '$fecha')";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if(!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        if($fila = $resultado->fetch_assoc()) { // Si se encuentra la factura
            $this->conexion->cerrarConexion();
            return $fila;
        }

        // Si no se encuentra la factura
        $this->conexion->cerrarConexion();
        return null;
    }

    // Inserta una factura en la BD
    public function insertar(Factura $factura) {
        $this->conexion->abrirConexion();

        $fecha = $factura->getFecha();
        $hora = $factura->getHora();
        $subtotal = $factura->getSubtotal();
        $iva = $factura->getIva();
        $total = $factura->getTotal();
        $idCliente = $factura->getIdCliente();
        $ciudad = $factura->getCiudad();
        $direccion = $factura->getDireccion();
        $estado = $factura->getEstado();

        $sql = "INSERT INTO factura(fecha, hora, subtotal, iva, total, idCliente, ciudad, direccion, estado) 
                VALUES('$fecha', '$hora', $subtotal, $iva, $total, $idCliente, '$ciudad', '$direccion', $estado)";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) // Si todo salio bien
            return $factura;

        // Si hubo un error
        return null;
    }

    public function actualizarEstadoVenta(int $id, int $nuevoEstado): bool {
        $this->conexion->abrirConexion();

        $sql = "UPDATE factura SET estado = $nuevoEstado WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
    
        $this->conexion->cerrarConexion();
        return $resultado ? true : false;
    }

    // Elimina una factura en la BD
    public function eliminar(int $id) {
        $factura = $this->obtenerPorId($id);

        if($factura !== null) { // Si se encuentra la factura
            $this->conexion->abrirConexion();
            $sql = "DELETE FROM factura WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();

            if($resultado) // Si todo salio bien
                return $factura;
        }

        return null;
    }
}
?>