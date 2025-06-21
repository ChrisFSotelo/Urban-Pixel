<?php

namespace features\factura\dao;

use ClienteDAO;
use Conexion;
use features\factura\model\Factura;

require_once "../../clientes/model/Cliente.php";
require_once "../../clientes/dao/ClienteDAO.php";
require_once "../../../../config/Conexion.php";
require_once "../model/Factura.php";

class FacturaDAO
{
    private Conexion $conexion;
    private ClienteDAO $clienteDAO;

    // Se instancian los objetos
    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->clienteDAO = new ClienteDAO();
    }

    // Lista todas las facturas
    public function listar(): array|null
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura ORDER BY id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $facturas = [];

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al listar las facturas \n");
            return null;
        }

        while ($fila = $resultado->fetch_object()) { // Listamos las facturas
            $cliente = $this->clienteDAO->obtenerPorId((int)$fila->idCliente); // Obtenemos el cliente que generó la factura

            $facturas[] = new Factura(
                (int)$fila->id,
                new DateTime($fila->fecha),
                new DateTime($fila->hora),
                (int)$fila->subtotal,
                (int)$fila->iva,
                (int)$fila->total,
                $cliente,
                $fila->ciudad,
                $fila->direccion
            );
        }

        $this->conexion->cerrarConexion();
        return $facturas;
    }

    // Obtener una factura por id
    public function obtenerPorId(int $id): Factura|null
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al obtener la factura \n");
            return null;
        }

        if ($fila = $resultado->fetch_object()) { // Si se encuentra la factura
            $cliente = $this->clienteDAO->obtenerPorId((int)$fila->idCliente); // Obtenemos el cliente que generó la factura

            $factura = new Factura(
                (int)$fila->id,
                new DateTime($fila->fecha),
                new DateTime($fila->hora),
                (int)$fila->subtotal,
                (int)$fila->iva,
                (int)$fila->total,
                $cliente,
                $fila->ciudad,
                $fila->direccion
            );

            $this->conexion->cerrarConexion();
            return $factura;
        }

        // Si no se encuentra la factura
        $this->conexion->cerrarConexion();
        echo("No se encontró la factura \n");
        return null;
    }

    // Obtener facturas por cliente
    public function obtenerPorIdCliente(int $idCliente): array|null
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura WHERE idCliente = $idCliente";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $facturas = [];

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al obtener las factura \n");
            return null;
        }

        while ($fila = $resultado->fetch_object()) { // Listamos las facturas
            $cliente = $this->clienteDAO->obtenerPorId((int)$fila->idCliente); // Obtenemos el cliente que generó la factura

            $facturas[] = new Factura(
                (int)$fila->id,
                new DateTime($fila->fecha),
                new DateTime($fila->hora),
                (int)$fila->subtotal,
                (int)$fila->iva,
                (int)$fila->total,
                $cliente,
                $fila->ciudad,
                $fila->direccion
            );
        }

        $this->conexion->cerrarConexion();
        return $facturas;
    }

    public function obtenerPorIdClienteHoraFecha(int $idCliente, string $hora, string $fecha): Factura|null
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM factura WHERE (idCliente = $idCliente) AND (hora = '$hora') AND (fecha = '$fecha')";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al obtener la factura \n");
            return null;
        }

        if ($fila = $resultado->fetch_object()) { // Si se encuentra la factura
            $cliente = $this->clienteDAO->obtenerPorId((int)$fila->idCliente); // Obtenemos el cliente que generó la factura

            $factura = new Factura(
                (int)$fila->id,
                new DateTime($fila->fecha),
                new DateTime($fila->hora),
                (int)$fila->subtotal,
                (int)$fila->iva,
                (int)$fila->total,
                $cliente,
                $fila->ciudad,
                $fila->direccion
            );

            $this->conexion->cerrarConexion();
            return $factura;
        }

        // Si no se encuentra la factura
        $this->conexion->cerrarConexion();
        echo("No se encontró la factura \n");
        return null;
    }

    // Inserta una factura en la BD
    public function insertar(Factura $factura): Factura|null
    {
        $this->conexion->abrirConexion();

        $fecha = $factura->getFecha();
        $hora = $factura->getHora();
        $subtotal = $factura->getSubtotal();
        $iva = $factura->getIva();
        $total = $factura->getTotal();
        $idCliente = $factura->getCliente()->getId();
        $ciudad = $factura->getCiudad();
        $direccion = $factura->getDireccion();

        $sql = "INSERT INTO factura(fecha, hora, subtotal, iva, total, idCliente, ciudad, direccion) 
                VALUES('$fecha', '$hora', $subtotal, $iva, $total, $idCliente, '$ciudad', '$direccion')";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) // Si todo salio bien
            return $factura;

        // Si hubo un error
        echo("Hubo un fallo al agregar la factura \n");
        return null;
    }

    // Elimina una factura en la BD
    public function eliminar(int $id): Factura|null
    {
        $factura = $this->obtenerPorId($id);

        if ($factura !== null) { // Si se encuentra la factura
            $this->conexion->abrirConexion();
            $sql = "DELETE FROM factura WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();

            if ($resultado) // Si todo salio bien
                return $factura;

            // Si hubo un error
            echo("Hubo un fallo al eliminar la factura \n");
        }

        return null;
    }
}

?>