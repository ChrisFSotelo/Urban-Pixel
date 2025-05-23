<?php 
    require_once "../model/Categoria.php";
    require_once "../dao/CategoriaDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $categoriaDAO = new CategoriaDAO();
        $datos = null;

        switch ($accion) {
            case "listar": {
                $categorias = $categoriaDAO->listar();

                if($categorias === null) {
                    $datos = ["error" => "Error al listar las categorias"];
                    break;
                }

                $datos = [
                    "mensaje" => "Categorias listadas correctamente",
                    "categorias" => generarJsonDeUnArray($categorias)
                ];

                break;
            };

            case "agregar": {
                // Creamos el objeto 'Categoria'
                $categoria = new Categoria(
                    0, 
                    $_POST["nombre"]
                );

                // Evitamos duplicados por nombre
                if($categoriaDAO->obtenerPorNombre($categoria->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe una categoria con ese nombre"];
                    break;
                }

                // Insertamos y validamos
                if($categoriaDAO->insertar($categoria) === null) {
                    $datos = ["error" => "Error al insertar la categoria"];
                    break;
                }

                $nuevaCategoria = $categoriaDAO->obtenerPorNombre($categoria->getNombre());
                $datos = [
                    "mensaje" => "Categoria agregada correctamente",
                    "categoria" => generarJsonDeUnObjeto($nuevaCategoria)
                ];
                
                break;
            };

            case "editar": {
                // Creamos el objeto 'Categoria'
                $categoria = new Categoria(
                    (int) $_POST["id"], 
                    $_POST["nombre"]
                );

                // Evitamos duplicados por nombre
                if($categoriaDAO->obtenerPorNombreExcluyendoCategoriaActual($categoria->getId(), $categoria->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe una categoria con ese nombre"];
                    break;
                }

                // Editamos y validamos
                if($categoriaDAO->actualizar($categoria) === null) {
                    $datos = ["error" => "Error al editar la categoria"];
                    break;
                }

                $categoriaEditada = $categoriaDAO->obtenerPorNombre($categoria->getNombre());
                $datos = [
                    "mensaje" => "Categoria editada correctamente",
                    "categoria" => generarJsonDeUnObjeto($categoriaEditada)
                ];
                
                break;
            };

            case "eliminar": {
                $id = (int) $_POST["id"];

                // Eliminamos y validamos
                if($categoriaDAO->eliminar($id) === null) {
                    $datos = ["error" => "Error al eliminar la categoría"];
                    break;
                }

                $datos = [
                    "mensaje" => "Categoría con id = ". $id ." eliminada correctamente"
                ];

                break;
            }
        }

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    else 
        header("Location: ../../../../");

    function generarJsonDeUnArray(array $categorias) {
        return array_map(function($producto) {
            return [
                'id' => $producto->getId(),
                'nombre' => $producto->getNombre()
            ];
        }, $categorias);
    }

    function generarJsonDeUnObjeto(Categoria $categoria) {
        return [
            'id' => $categoria->getId(),
            'nombre' => $categoria->getNombre()
        ];
    }
?>