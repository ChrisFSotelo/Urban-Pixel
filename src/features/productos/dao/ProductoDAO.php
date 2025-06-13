<?php
namespace dao;
require_once __DIR__ . '/../../../../config/Conexion.php';
require_once __DIR__ . '/../model/Producto.php';

use Conexion;
use model\Producto;

class ProductoDAO{
    private $conexion;

    public function __construct(){
        $this->conexion = new Conexion();
    }

    public function listar() {
        $this->conexion->abrirConexion();

        $sql = "SELECT * FROM producto ORDER BY id ASC";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $productos = [];

        if(!$resultado) {
            $this->conexion->cerrarConexion();
            echo "Hubo un error al listar los productos";
            return null;
        }

        while($fila = $resultado->fetch_assoc())
            $productos[] = $fila;

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

   
    public function RegistrarProducto(Producto $producto) {
        $this->conexion->abrirConexion();
    
        $nombre = $producto->getNombre();
        $cantidad = $producto->getCantidad();
        $precio = $producto->getPrecio();
        $idCategoria = $producto->getCategoria()->getId(); 

    
        $sql = "INSERT INTO producto (nombre, cantidad, precio, idCategoria)
            VALUES ('$nombre', $cantidad, $precio, $idCategoria)";
    
        $resultado = $this->conexion->ejecutarConsulta($sql);
    
        $this->conexion->cerrarConexion();
    
        if ($resultado)
            return $producto;
    
        echo "Hubo un error al registrar el producto";
        return null;
    }
    
}

