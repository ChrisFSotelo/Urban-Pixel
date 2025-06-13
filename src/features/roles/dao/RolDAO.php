<?php
    namespace dao;
    require_once __DIR__ . "/../../../../config/Conexion.php";
    require_once __DIR__ . '/../model/Rol.php';

    use Conexion;
    use Rol;

    class RolDAO {
        private Conexion $conexion;

        // Se instancian los objetos
        public function __construct() {
            $this->conexion = new Conexion();
        }

        // Lista todos los roles
        public function listar(): array | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM rol ORDER BY id ASC";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $roles = [];

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al listar los roles \n");
                return null;
            }
            
            while($fila = $resultado->fetch_object()) { // Listamos los roles
                $roles[] = new Rol(
                    (int) $fila->id, 
                    $fila->nombre
                );
            }

            $this->conexion->cerrarConexion();
            return $roles;
        }

        // Obtener un rol por id
        public function obtenerPorId(int $id) {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM rol WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el rol \n");
                return null;
            }
            
            if($fila = $resultado->fetch_assoc()) { // Si se encuentra el rol
                $this->conexion->cerrarConexion();
                return $fila;
            }

            // Si no se encuentra el rol
            $this->conexion->cerrarConexion();
            echo("No se encontró el rol \n");
            return null;
        }

        // Obtener un rol por nombre
        public function obtenerPorNombre(string $nombre): Rol | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM rol WHERE nombre = '$nombre'";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el rol \n");
                return null;
            }
            
            if($fila = $resultado->fetch_object()) { // Si se encuentra el rol                
                $rol = new Rol(
                    (int) $fila->id, 
                    $fila->nombre
                );

                $this->conexion->cerrarConexion();
                return $rol;
            }

            // Si no se encuentra el rol
            $this->conexion->cerrarConexion();
            echo("No se encontró el rol \n");
            return null;
        }

        // Obtener un rol por nombre excluyendo uno
        public function obtenerPorNombreExcluyendoRolActual(int $id, string $nombre): Rol | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM rol WHERE (id != $id) AND (nombre = '$nombre')";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el rol \n");
                return null;
            }
            
            if($fila = $resultado->fetch_object()) { // Si se encuentra el rol                
                $rol = new Rol(
                    (int) $fila->id, 
                    $fila->nombre
                );

                $this->conexion->cerrarConexion();
                return $rol;
            }

            // Si no se encuentra el rol
            $this->conexion->cerrarConexion();
            echo("No se encontró el rol \n");
            return null;
        }

        // Inserta un rol en la BD
        public function insertar(Rol $rol): Rol | null {
            $this->conexion->abrirConexion();

            $nombre = $rol->getNombre();

            $sql = "INSERT INTO rol(nombre) VALUES('$nombre')";

            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();
            
            if($resultado) // Si todo salio bien
                return $rol;

            // Si hubo un error
            echo("Hubo un fallo al agregar el rol \n");
            return null;
        }

        // Actualiza un rol en la BD
        public function actualizar(Rol $rol): Rol | null {
            $this->conexion->abrirConexion();

            $id = $rol->getId();
            $nombre = $rol->getNombre();

            $sql = "UPDATE rol SET nombre = '$nombre' WHERE id = $id";

            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();
            
            if($resultado) // Si todo salio bien
                return $rol;

            // Si hubo un error
            echo("Hubo un fallo al actualizar el rol \n");
            return null;
        }

        // Elimina un rol en la BD
        public function eliminar(int $id): Rol | null {
            $rol = $this->obtenerPorId($id);

            if($rol !== null) { // Si se encuentra el rol
                $this->conexion->abrirConexion();
                $sql = "DELETE FROM rol WHERE id = $id";
                $resultado = $this->conexion->ejecutarConsulta($sql);
                $this->conexion->cerrarConexion();

                if($resultado) // Si todo salio bien
                    return $rol;

                // Si hubo un error
                echo("Hubo un fallo al eliminar el rol \n");
            }

            return null;
        }
    }
?>