<?php
namespace dao;

require_once __DIR__ . '/../../../../config/Conexion.php';
require_once __DIR__ . '/../model/Producto.php';

use Conexion;
use model\Producto;


class ProductoDAO{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function listar(): array
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT id, nombre, cantidad, precio FROM producto ORDER BY id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) {
            $this->conexion->cerrarConexion();
            throw new Exception("Error al obtener los productos.");
        }

        $productos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = new Producto(
                $fila['id'],
                $fila['nombre'],
                $fila['cantidad'],
                $fila['precio']
            );
        }

        $this->conexion->cerrarConexion();
        return $productos;
    }

    public function buscarPorNombre(string $nombre): array
    {
        $this->conexion->abrirConexion();
        $querySQL = "SELECT * FROM producto WHERE nombre LIKE '%$nombre%' ORDER BY id ASC";
        $resultado = $this->conexion->ejecutarConsulta($querySQL);

        if (!$resultado)
        {
            $this->conexion->cerrarConexion();
            throw new Exception("Error al buscar el producto por nombre.");
        }

        $productos = [];

        while ($row = $resultado->fetch_assoc())
        {
            $productos[] = new Producto(
                $row['id'],
                $row['nombre'],
                $row['cantidad'],
                $row['precio'],
            );
        }

        $this->conexion->cerrarConexion();

        return $productos;
    }
}
