<?php
    namespace dao;
    require_once __DIR__ . "/../../../../config/Conexion.php";
    require_once "../../categorias/model/Categoria.php";
    
    use Conexion;
    use model\Categoria;

    class CategoriaDAO {
        private $conexion;
        
        public function __construct() {
            $this->conexion = new Conexion();
        }

        public function insertar (Categoria $categoria) {
            $this->conexion->abrirConexion();
            $nombre = $categoria->getNombre();

            $sql = "INSERT INTO categoria (nombre) VALUES('$nombre')";
            $this->conexion->ejecutarConsulta($sql);
        }

        public function obtenerPorId($id){
            $this->conexion->abrirConexion();
            
            $sql = "SELECT * FROM categoria WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $categoria = null;

            if($fila = $resultado->fetch_assoc())
                $categoria = $fila;

            $this->conexion->cerrarConexion();
            return $categoria;
        }

        public function obtenerPorNombre($nombre){
            $this->conexion->abrirConexion();
            
            $sql = "SELECT * FROM categoria WHERE nombre = '$nombre'";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $categoria=null;

            if($fila = $resultado->fetch_assoc())
                $categoria = new Categoria($fila['id'], $fila['nombre']);

            $this->conexion->cerrarConexion();
            return $categoria;
        }

        public function listar() {
            $this->conexion->abrirConexion();

            $sql = "SELECT * FROM categoria";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $categorias = [];

            while($fila = $resultado->fetch_assoc())
                $categorias[] = $fila;

            $this->conexion->cerrarConexion();
            return $categorias;
        }

        public function actualizar(Categoria $categoria) {
            $this->conexion->abrirConexion();

            $id = $categoria->getId();
            $nombre = $categoria->getNombre();

            $sql = "UPDATE categoria SET nombre = '$nombre' WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            $this->conexion->cerrarConexion();
            return $resultado;
        }

        public function eliminar($id) {
            $this->conexion->abrirConexion();

            $sql = "DELETE FROM categoria WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            $this->conexion->cerrarConexion();
            return $resultado;
        }
    }
?>