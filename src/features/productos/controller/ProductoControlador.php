<?php
    use dao\UsuarioDAO;

    require_once "../../categorias/model/Categoria.php";
    require_once "../../categorias/dao/CategoriaDAO.php";
    require_once "../model/Producto.php";
    require_once "../dao/ProductoDAO.php";
    require_once "../../users/models/Usuario.php";
    require_once "../../users/dao/UsuarioDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $productoDAO = new ProductoDAO();
        $categoriaDAO = new CategoriaDAO();
        $adminDAO = new UsuarioDAO();
        $datos = null;

        switch ($accion) {
            case "listar": {
                $productos = $productoDAO->listar();

                if($productos === null) {
                    $datos = ["error" => "Error al listar los productos"];
                    break;
                }

                $datos = [
                    "mensaje" => "Productos listados correctamente",
                    "productos" => generarJsonDeUnArray($productos)
                ];

                break;
            };

            case "agregar": {
                // Obtenemos los objetos reales desde sus DAOs
                $categoria = $categoriaDAO->obtenerPorId((int) $_POST["idCategoria"]);
                $administrador = $adminDAO->obtenerPorId((int) $_POST["idAdministrador"]);

                // Validamos que existan
                if($categoria === null || $administrador === null) {
                    $datos = ["error" => "Categoría o administrador no encontrados"];
                    break;
                }

                // Creamos el objeto 'Producto'
                $producto = new Producto(
                    0, 
                    $_POST["nombre"],
                    (int) $_POST["cantidad"],
                    (int) $_POST["precio"],
                    $categoria,
                    $administrador
                );

                // Evitamos duplicados por nombre
                if($productoDAO->obtenerPorNombre($producto->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe un producto con ese nombre"];
                    break;
                }

                // Insertamos y validamos
                if($productoDAO->insertar($producto) === null) {
                    $datos = ["error" => "Error al insertar el producto"];
                    break;
                }

                $nuevoProducto = $productoDAO->obtenerPorNombre($producto->getNombre());
                $datos = [
                    "mensaje" => "Producto agregado correctamente",
                    "producto" => generarJsonDeUnObjeto($nuevoProducto)
                ];

                break;
            };

            case "editar": {
                // Obtenemos los objetos reales desde sus DAOs
                $categoria = $categoriaDAO->obtenerPorId((int) $_POST["idCategoria"]);
                $administrador = $adminDAO->obtenerPorId((int) $_POST["idAdministrador"]);

                // Validamos que existan
                if($categoria === null || $administrador === null) {
                    $datos = ["error" => "Categoría o administrador no encontrados"];
                    break;
                }

                // Creamos el objeto 'Producto'
                $producto = new Producto(
                    (int) $_POST["id"], 
                    $_POST["nombre"],
                    (int) $_POST["cantidad"],
                    (int) $_POST["precio"],
                    $categoria,
                    $administrador
                );

                // Evitamos duplicados por nombre
                if($productoDAO->obtenerPorNombreExcluyendoProductoActual($producto->getId(), $producto->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe un producto con ese nombre"];
                    break;
                }

                // Editamos y validamos
                if($productoDAO->actualizar($producto) === null) {
                    $datos = ["error" => "Error al editar el producto"];
                    break;
                }

                $nuevoProducto = $productoDAO->obtenerPorNombre($producto->getNombre());
                $datos = [
                    "mensaje" => "Producto editado correctamente",
                    "producto" => generarJsonDeUnObjeto($nuevoProducto)
                ];

                break;
            };
        }

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    else 
        header("Location: ../../../../");

    // Función para generar el Json de un arreglo de objetos 
    function generarJsonDeUnArray(array $productos) {
        return array_map(function($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre(),
                'cantidad' => $producto->getCantidad(),
                'precio' => $producto->getPrecio(),
                'categoria' => [
                    'id' => $producto->getCategoria()->getId(),
                    'nombre' => $producto->getCategoria()->getNombre(),
                ],
                'administrador' => [
                    'id' => $producto->getAdministrador()->getId(),
                    'nombre' => $producto->getAdministrador()->getNombre(),
                ]
            ];
        }, $productos);
    }

    // Función para generar el Json de un solo objeto
    function generarJsonDeUnObjeto(Producto $producto) {
        return [
            'id' => $producto->getId(),
            'nombre' => $producto->getNombre(),
            'cantidad' => $producto->getCantidad(),
            'precio' => $producto->getPrecio(),
            'categoria' => [
                'id' => $producto->getCategoria()->getId(),
                'nombre' => $producto->getCategoria()->getNombre(),
            ],
            'administrador' => [
                'id' => $producto->getAdministrador()->getId(),
                'nombre' => $producto->getAdministrador()->getNombre(),
            ]
        ];
    }

    function listarProductos()
    {
        $categorias = array();
        $usuarios = array();
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $productoDAO = new ProductoDAO();
        $conexion->ejecutarConsulta($productoDAO->listar());

        while($registro = $conexion->siguienteRegistro())
        {
            $categoria = null;
            $usuario = null;

            if(array_key_exists($registro[4], $categorias))
            {
                $categoria = $categorias[$registro[4]];
            }
            else
            {
                $categoria = new Categoria($registro[4]);
                $categoria->consultar();
                $categorias[$registro[4]] = $categoria;
            }

            if(array_key_exists($registro[5], $usuarios))
            {
                $usuario = $usuarios[$registro[5]];
            }
            else
            {
                $usuario = new Usuario($registro[5]);
                $usuario->consultar();
                $usuarios[$registro[5]] = $usuario;
            }

            $producto = new Producto(
                $registro[0],
                $registro[1],
                $registro[2],
                $registro[3],
                $categoria,
                $usuario
            );

            array_push($productos, $producto);
        }

        $conexion->cerrarConexion();
        return $productos;
    }


?>