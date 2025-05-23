<?php
    require_once __DIR__. "/../model/Categoria.php";
    require_once "../../../../config/Conexion.php";

    class CategoriaDAO {
        private $conexion;
        
        // Se instancian los objetos
        public function __construct() {
            $this->conexion = new Conexion();
        }

        // Lista todos las categorías
        public function listar(): array | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM categoria ORDER BY id ASC";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $categorias = [];

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al listar las categorías \n");
                return null;
            }

            while ($fila = $resultado->fetch_assoc()) // Listamos
                $categorias[] = new Categoria($fila['id'], $fila['nombre']);

            $this->conexion->cerrarConexion();
            return $categorias;
        }

        // Obtener una categoría por id
        public function obtenerPorId(int $id): Categoria | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM categoria WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener la categoría \n");
                return null;
            }

            if($fila = $resultado->fetch_assoc()) { // Si se encuentra la categoría
                $categoria = new Categoria($fila['id'], $fila['nombre']);

                $this->conexion->cerrarConexion();
                return $categoria;
            }

            // Si no se encuentra la categoría
            $this->conexion->cerrarConexion();
            echo("No se encontró la categoría \n");
            return null;
        }

        // Obtener una categoría por nombre
        public function obtenerPorNombre(string $nombre): Categoria | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM categoria WHERE nombre = '$nombre'";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener la categoría \n");
                return null;
            }

            if($fila = $resultado->fetch_assoc()) { // Si se encuentra la categoría
                $categoria = new Categoria($fila['id'], $fila['nombre']);

                $this->conexion->cerrarConexion();
                return $categoria;
            }

            // Si no se encuentra la categoría
            $this->conexion->cerrarConexion();
            echo("No se encontró la categoría \n");
            return null;
        }

        // Obtener una categoría por nombre excluyendo el objeto actual
        public function obtenerPorNombreExcluyendoCategoriaActual(int $id, string $nombre): Categoria | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM categoria WHERE (id != $id) AND (nombre = '$nombre')";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener la categoría \n");
                return null;
            }

            if($fila = $resultado->fetch_assoc()) { // Si se encuentra la categoría
                $categoria = new Categoria($fila['id'], $fila['nombre']);

                $this->conexion->cerrarConexion();
                return $categoria;
            }

            // Si no se encuentra la categoría
            $this->conexion->cerrarConexion();
            echo("No se encontró la categoría \n");
            return null;
        }

        // Inserta una categoría en la BD
        public function insertar (Categoria $categoria): Categoria | null {
            $this->conexion->abrirConexion();

            $nombre = $categoria->getNombre();

            $sql = "INSERT INTO categoria (nombre) VALUES('$nombre')";

            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();

            if($resultado) // Si todo salio bien
                return $categoria;

            // Si hubo un error
            echo("Hubo un fallo al agregar la categoría \n");
            return null;
        }

        // Actualiza una categoría en la BD
        public function actualizar(Categoria $categoria): Categoria | null {
            $this->conexion->abrirConexion();

            $id = $categoria->getId();
            $nombre = $categoria->getNombre();

            $sql = "UPDATE categoria SET nombre = '$nombre' WHERE id = $id";

            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();

            if($resultado) // Si todo salio bien
                return $categoria;

            // Si hubo un error
            echo("Hubo un fallo al agregar la categoría \n");
            return null;
        }

        // Elimina una categoría en la BD
        public function eliminar($id): Categoria | null {
            $categoria = $this->obtenerPorId($id);

            if($categoria !== null) {
                $this->conexion->abrirConexion();
                $sql = "DELETE FROM categoria WHERE id = $id";
                $resultado = $this->conexion->ejecutarConsulta($sql);
                $this->conexion->cerrarConexion();

                if($resultado) // Si todo salio bien
                    return $categoria;

                // Si hubo un error
                echo("Hubo un fallo al eliminar la categoría \n");
            }

            return null;
        }
    }
?>