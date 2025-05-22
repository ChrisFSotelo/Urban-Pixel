<?php
require_once 'Categoria.php';
require_once 'Conexion.php';
class categoriaDAO{

    private $conexion;
    
    public function __construct() {
        $this->conexion = new Conexion();
    }

public function insertar (Categoria $categoria){
$this->conexion->AbrirConexion();
$nombre = $Categoria->getNombre

    $sql = "INSERT INTO categoria (nombre) VALUES(:nombre)";
    $this->conexion->ejecutarConsulta($sql);
}

public function obtenerPorId($id){
    $this->conexion->abrirConexion();
    
    $sql = "SELECT * FROM categoria WHERE idCategoria = $id";
    $resultado = $this->conexion->ejecutarConsulta($sql);
    $categoria=null;

    if($fila = $resultado->fetch_assoc()){
        $categoria = new Categoria($fila['idCategoria'], $fila['nombre'])
    }

    $this-conexion->cerrarConexion();
    return $categoria
}

public function listar() {
    $this->conexion->abrirConexion();

    $sql = "SELECT * FROM categoria";
    $resultado = $this->conexion->ejecutarConsulta($sql);
    $categorias = [];

    while ($fila = $resultado->fetch_assoc()) {
        $categorias[] = new Categoria($fila['idCategoria'], $fila['nombre']);
    }

    $this->conexion->cerrarConexion();
    return $categorias;
}
    public function actualizar(Categoria $categoria) {
        $this->conexion->abrirConexion();

        $id = $categoria->getId();
        $nombre = $categoria->getNombre();

        $sql = "UPDATE categorias SET nombre = '$nombre' WHERE idCategoria = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $this->conexion->cerrarConexion();
        return $resultado;
    }

    public function eliminar($id) {
        $this->conexion->abrirConexion();

        $sql = "DELETE FROM categoria WHERE idCategoria = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $this->conexion->cerrarConexion();
        return $resultado;
    }
}

?>