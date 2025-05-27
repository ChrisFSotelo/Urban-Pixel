<?php 
    require_once "../model/Rol.php";
    require_once "../dao/RolDAO.php";

    header('Content-Type: application/json; charset=utf-8');

    if(isset($_REQUEST["accion"])) {
        $accion = $_REQUEST["accion"];
        $rolDAO = new RolDAO();
        $datos = null;

        switch ($accion) {
            case "listar": {
                $roles = $rolDAO->listar();

                if($roles === null) {
                    $datos = ["error" => "Error al listar los roles"];
                    break;
                }

                $datos = [
                    "mensaje" => "Roles listados correctamente",
                    "roles" => generarJsonDeUnArray($roles)
                ];

                break;
            };

            case "agregar": {
                // Creamos el objeto 'Rol'
                $rol = new Rol(
                    0, 
                    $_POST["nombre"]
                );

                // Evitamos duplicados por nombre
                if($rolDAO->obtenerPorNombre($rol->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe un rol con ese nombre"];
                    break;
                }

                // Insertamos y validamos
                if($rolDAO->insertar($rol) === null) {
                    $datos = ["error" => "Error al insertar el rol"];
                    break;
                }

                $nuevoRol = $rolDAO->obtenerPorNombre($rol->getNombre());
                $datos = [
                    "mensaje" => "Rol agregado correctamente",
                    "rol" => generarJsonDeUnObjeto($nuevoRol)
                ];
                
                break;
            };

            case "editar": {
                // Creamos el objeto 'Rol'
                $rol = new Rol(
                    (int) $_POST["id"], 
                    $_POST["nombre"]
                );

                // Evitamos duplicados por nombre
                if($rolDAO->obtenerPorNombreExcluyendoRolActual($rol->getId(), $rol->getNombre()) !== null) {
                    $datos = ["error" => "Ya existe un rol con ese nombre"];
                    break;
                }

                // Editamos y validamos
                if($rolDAO->actualizar($rol) === null) {
                    $datos = ["error" => "Error al editar el rol"];
                    break;
                }

                $rolModificado = $rolDAO->obtenerPorNombre($rol->getNombre());
                $datos = [
                    "mensaje" => "Rol editado correctamente",
                    "rol" => generarJsonDeUnObjeto($rolModificado)
                ];
                
                break;
            };

            case "eliminar": {
                $id = (int) $_POST["id"];

                if($rolDAO->eliminar($id) === null) {
                    $datos = ["error" => "Error al eliminar el rol"];
                    break;
                }

                $datos = [
                    "mensaje" => "Rol con id = ". $id ." eliminado correctamente"
                ];

                break;
            }
        }

        echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    }
    else 
        header("Location: ../../../../");

    function generarJsonDeUnArray(array $roles) {
        return array_map(function($rol) {
            return [
                'id' => $rol->getId(),
                'nombre' => $rol->getNombre()
            ];
        }, $roles);
    }

    function generarJsonDeUnObjeto(Rol $rol) {
        return [
            'id' => $rol->getId(),
            'nombre' => $rol->getNombre()
        ];
    }
?>