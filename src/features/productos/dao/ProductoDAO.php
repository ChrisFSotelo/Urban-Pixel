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

        $sql = "SELECT p.*, c.nombre as categoria
            FROM producto p
            JOIN categoria c
            ON (p.idCategoria = c.id) 
            ORDER BY p.id ASC";
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

    public function obtenerPorId($id) {
        $this->conexion->abrirConexion();
        $querySQL = "SELECT * FROM producto WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($querySQL);
        $producto = null;

        if(!$resultado) {
            $this->conexion->cerrarConexion();
            echo ("Error al buscar el producto por id.");
            return null;
        }

        if($fila = $resultado->fetch_assoc())
            $producto = $fila;    

        $this->conexion->cerrarConexion();
        return $producto;
    }

    public function RegistrarProducto(Producto $producto) {
        $this->conexion->abrirConexion();
    
        $nombre = $producto->getNombre();
        $cantidad = $producto->getCantidad();
        $precio = $producto->getPrecio();
        $idCategoria = $producto->getCategoria()->getId(); 
        $estado= $producto->getEstado();
        $descripcion = $producto->getDescripcion();
        $datosImagen = $producto->getDatosImagen();
        $nombreImagen = $producto->getNombreImagen();
        $tipoImagen = $producto->getTipoImagen();
    
        $sql = "INSERT INTO producto (nombre, cantidad, precio, idCategoria, estado, descripcion, datosImagen, nombreImagen, tipoImagen)
            VALUES ('$nombre', $cantidad, $precio, $idCategoria, $estado, '$descripcion', '$datosImagen', '$nombreImagen', '$tipoImagen')";
    
        $resultado = $this->conexion->ejecutarConsulta($sql);
    
        $this->conexion->cerrarConexion();
    
        if ($resultado)
            return $producto;
    
        echo "Hubo un error al registrar el producto";
        return null;
    }

    
    public function actualizarEstado(int $id, int $nuevoEstado): bool {
        $this->conexion->abrirConexion();
    
        $sql = "UPDATE producto SET estado = $nuevoEstado WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
    
        $this->conexion->cerrarConexion();
    
        return $resultado ? true : false;
    }
    
    public function actualizarProducto(Producto $producto) {
        $this->conexion->abrirConexion();
    
        $id = $producto->getId();
        $nombre = $producto->getNombre();
        $cantidad = $producto->getCantidad();
        $precio = $producto->getPrecio();
        $descripcion = $producto->getDescripcion();
        $idCategoria = $producto->getCategoria()->getId(); 
        $datosImagen = $producto->getDatosImagen(); 
        $nombreImagen = $producto->getNombreImagen(); 
        $tipoImagen = $producto->getTipoImagen(); 

        $sql = "UPDATE producto 
            SET nombre = '$nombre', cantidad = $cantidad, precio = $precio, descripcion='$descripcion', idCategoria = $idCategoria,
                datosImagen = '$datosImagen', nombreImagen = '$nombreImagen', tipoImagen = '$tipoImagen'
            WHERE id = $id";
    
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
    
        if($resultado)
            return $producto;
    
        echo "Hubo un error al actualizar el producto";
        return null;
    }
}

