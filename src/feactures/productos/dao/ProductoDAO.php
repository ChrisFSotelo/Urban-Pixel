<?php 
    require_once "Conexion.php";
    require_once "Categoria.php";
    require_once "CategoriaDAO.php";
    require_once "Producto.php";

    class ProductoDAO {
        private Conexion $conexion;
        private $categoriaDAO;

        // Se instancian los objetos
        public function __construct() {
            $this->conexion = new Conexion();
            $this->categoriaDAO = new CategoriaDAO();
        }

        // Lista todos los productos
        public function listar(): array | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM productos ORDER BY id ASC";
            $resultado = $this->conexion->ejecutarConsulta($sql);
            $productos = [];

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al listar los productos \n");
                return null;
            }
            
            while($fila = $resultado->fetch_object()) { // Listamos los productos
                $categoria = $this->categoriaDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos la categoria del producto

                $productos[] = new Producto(
                    (int) $fila->id, 
                    $fila->nombre,
                    (int) $fila->cantidad,
                    (int) $fila->precio,
                    $categoria
                );
            }

            $this->conexion->cerrarConexion();
            return $productos;
        }

        // Obtener un producto por id
        public function obtenerPorId(int $id): Producto | null {
            $this->conexion->abrirConexion();
            $sql = "SELECT * FROM productos WHERE id = $id";
            $resultado = $this->conexion->ejecutarConsulta($sql);

            if(!$resultado) { // Si hubo un error
                $this->conexion->cerrarConexion();
                echo("Hubo un fallo al obtener el producto \n");
                return null;
            }
            
            if($fila = $resultado->fetch_object()) { // Si se encuentra el producto
                $categoria = $this->categoriaDAO->obtenerPorId((int) $fila->idCategoria); // Obtenemos la categoria del producto

                $producto = new Producto(
                    (int) $fila->id, 
                    $fila->nombre,
                    (int) $fila->cantidad,
                    (int) $fila->precio,
                    $categoria
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

            $sql = "INSERT INTO productos(nombre, cantidad, precio, idcategoria) 
                VALUES('$nombre', $cantidad, $precio, $idCategoria)";

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

            $sql = "UPDATE productos
                SET nombre = '$nombre',
                    cantidad = $cantidad,
                    precio = $precio,
                    idcategoria = $idCategoria 
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
                $sql = "DELETE FROM productos WHERE id = $id";
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