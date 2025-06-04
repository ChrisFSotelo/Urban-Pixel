<?php
require_once __DIR__ . '/../../../../config/Conexion.php';
require_once __DIR__ . '/../model/Product.php';

class ProductDAO
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function listar(): array
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM producto ORDER BY id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) {
            $this->conexion->cerrarConexion();
            throw new Exception("Error al obtener los productos.");
        }

        $productos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = new Product(
                $fila['id'],
                $fila['nombre'],
                $fila['cantidad'],
                $fila['precio'],
            );
        }

        $this->conexion->cerrarConexion();
        return $productos;
    }
}
