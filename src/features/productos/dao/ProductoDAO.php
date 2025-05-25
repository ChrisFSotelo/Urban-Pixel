<?php
    use dao\UsuarioDAO;

    require_once "../../../../config/Conexion.php";
    require_once "../../categorias//model/Categoria.php";
    require_once "../../categorias/dao/CategoriaDAO.php";
    require_once "../model/Producto.php";
    require_once "../../users/models/Usuario.php";
    require_once "../../users/dao/UsuarioDAO.php";

    class ProductoDAO {
        private Conexion $conexion;
        private CategoriaDAO $categoriaDAO;
        private UsuarioDAO $adminDAO;

        // Se instancian los objetos
        public function __construct() {
            $this->conexion = new Conexion();
            $this->categoriaDAO = new CategoriaDAO();
            $this->adminDAO = new UsuarioDAO();
        }

        // Lista todos los productos
        public function listar(): array | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM producto ORDER BY id ASC";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $productos = [];

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al listar los productos \n");
                return null;
            }
            
            while($fila = $resultado->fetch_object()) { // Listamos los productos
                $categoria = $this->categoriaDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos la categoria del producto
                $administrador = $this->adminDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos el administrador del producto

                $productos[] = new Producto(
                    (int) $fila->id, 
                    $fila->nombre,
                    (int) $fila->cantidad,
                    (int) $fila->precio,
                    $categoria,
                    $administrador
                );
            }

            $this->conexion->cerrarConexion();
            return $productos;
        }

        // Obtener un producto por id
        public function obtenerPorId(int $id): Producto | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM producto WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el producto \n");
                return null;
            }
            
            if($fila = $resultado->fetch_object()) { // Si se encuentra el producto
                $categoria = $this->categoriaDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos la categoria del producto
                $administrador = $this->adminDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos el administrador del producto

                $producto = new Producto(
                    (int) $fila->id, 
                    $fila->nombre,
                    (int) $fila->cantidad,
                    (int) $fila->precio,
                    $categoria,
                    $administrador
                );

                $this->conexion->cerrarConexion();
                return $producto;
            }

            // Si no se encuentra el producto
            $this->conexion->cerrarConexion();
            echo("No se encontró el producto \n");
            return null;
        }

        // Obtener un producto por nombre
        public function obtenerPorNombre(string $nombre): Producto | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM producto WHERE nombre = '$nombre'";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el producto \n");
                return null;
            }
            
            if($fila = $resultado->fetch_object()) { // Si se encuentra el producto
                $categoria = $this->categoriaDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos la categoria del producto
                $administrador = $this->adminDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos el administrador del producto

                $producto = new Producto(
                    (int) $fila->id, 
                    $fila->nombre,
                    (int) $fila->cantidad,
                    (int) $fila->precio,
                    $categoria,
                    $administrador
                );

                $this->conexion->cerrarConexion();
                return $producto;
            }

            // Si no se encuentra el producto
            $this->conexion->cerrarConexion();
            echo("No se encontró el producto \n");
            return null;
        }

        public function obtenerPorNombreExcluyendoProductoActual(int $id, string $nombre): Producto | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM producto WHERE (id != $id) AND (nombre = '$nombre')";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el producto \n");
                return null;
            }
            
            if($fila = $resultado->fetch_object()) { // Si se encuentra el producto
                $categoria = $this->categoriaDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos la categoria del producto
                $administrador = $this->adminDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos el administrador del producto

                $producto = new Producto(
                    (int) $fila->id, 
                    $fila->nombre,
                    (int) $fila->cantidad,
                    (int) $fila->precio,
                    $categoria,
                    $administrador
                );

                $this->conexion->cerrarConexion();
                return $producto;
            }

            // Si no se encuentra el producto
            $this->conexion->cerrarConexion();
            echo("No se encontró el producto \n");
            return null;
        }

        // Inserta un producto en la BD
        public function insertar(Producto $producto): Producto | null {
            $this->conexion->abrirConexion();

            $nombre = $producto->getNombre();
            $cantidad = $producto->getCantidad();
            $precio = $producto->getPrecio();
            $idCategoria = $producto->getCategoria()->getId();
            $idAministrador = $producto->getAdministrador()->getId();

            $sql = "INSERT INTO producto(nombre, cantidad, precio, idCategoria, idAdministrador) 
                VALUES('$nombre', $cantidad, $precio, $idCategoria, $idAministrador)";

            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();
            
            if($resultado) // Si todo salio bien
                return $producto;

            // Si hubo un error
            echo("Hubo un fallo al agregar el producto \n");
            return null;
        }

        // Actualiza un producto en la BD
        public function actualizar(Producto $producto): Producto | null {
            $this->conexion->abrirConexion();

            $id = $producto->getId();
            $nombre = $producto->getNombre();
            $cantidad = $producto->getCantidad();
            $precio = $producto->getPrecio();
            $idCategoria = $producto->getCategoria()->getId();
            $idAministrador = $producto->getAdministrador()->getId();

            $sql = "UPDATE producto
                SET nombre = '$nombre',
                    cantidad = $cantidad,
                    precio = $precio,
                    idCategoria = $idCategoria, 
                    idAdministrador = $idAministrador 
                WHERE id = $id";

            $resultado = $this->conexion->ejecutarConsulta($sql);
            $this->conexion->cerrarConexion();
            
            if($resultado) // Si todo salio bien
                return $producto;

            // Si hubo un error
            echo("Hubo un fallo al actualizar el producto \n");
            return null;
        }

        // Elimina un producto en la BD
        public function eliminar(int $id): Producto | null {
            $producto = $this->obtenerPorId($id);

            if($producto !== null) { // Si se encuentra el producto
                $this->conexion->abrirConexion();
                $sql = "DELETE FROM producto WHERE id = $id";
                $resultado = $this->conexion->ejecutarConsulta($sql);
                $this->conexion->cerrarConexion();

                if($resultado) // Si todo salio bien
                    return $producto;

                // Si hubo un error
                echo("Hubo un fallo al eliminar el producto \n");
            }

            return null;
        }
    }
?>