<?php

namespace dao;

require_once "../../../../config/Conexion.php";
require_once "../../producto_factura/model/ProductoFactura.php";

use Conexion;

class ProductoFacturaDAO {
    private Conexion $conexion;

    // Se instancian los objetos
    public function __construct() {
        $this->conexion = new Conexion();
    }

    // Obtener los detalles de una factura por id
    public function obtenerPorIdFactura(int $idFactura) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM producto_factura WHERE idFactura = $idFactura";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $detallesFactura = [];

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        while ($fila = $resultado->fetch_assoc()) // Si se encuentran los detalles
            $detallesFactura[] = $fila;

        $this->conexion->cerrarConexion();
        return $detallesFactura;
    }

    // Inserta los detalles de una factura
    public function insertar(array $detallesFactura) {
        $this->conexion->abrirConexion();

        foreach ($detallesFactura as $detalle) {
            $idFactura = $detalle->getIdFactura();
            $idProducto = $detalle->getIdProducto();
            $cantidad = $detalle->getCantidad();
            $precioVenta = $detalle->getPrecioVenta();

            $sql = "INSERT INTO producto_factura(idFactura, idProducto, cantidad, precioVenta)
                    VALUES($idFactura, $idProducto, $cantidad, $precioVenta)";

            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                return null;
            }
        }

        // Si todo salio bien
        $this->conexion->cerrarConexion();
        return $detallesFactura;
    }

    // Elimina los detalles de una factura en la BD
    public function eliminar(int $idFactura) {
        $detallesFactura = $this->obtenerPorIdFactura($idFactura);

        if($detallesFactura !== null) { // Si se encuentra la factura
            $this->conexion->abrirConexion();
            $sql = "DELETE FROM producto_factura WHERE idFactura = $idFactura";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();

            if ($resultado) // Si todo salio bien
                return $detallesFactura;
        }

        return null;
    }
}
?>