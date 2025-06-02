<?php
namespace dao;

require_once __DIR__ . "/../../../../config/Conexion.php";
require_once __DIR__ . '/../model/Persona.php';

require_once __DIR__ . '/../../roles/model/Rol.php';
require_once __DIR__ . '/../../roles/dao/RolDAO.php';

use Conexion;
use model\Usuario;
use RolDAO;

class UsuarioDAO{
    private $conexion;
    private RolDAO $rolDAO;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }
    public function AutenticarUsuario($correo, $clave) {
        $this->conexion->abrirConexion();

        $sql = "SELECT id FROM usuario WHERE correo = '$correo' AND clave = '$clave'";

        $resultado = $this->conexion->ejecutarConsulta($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // Crear y retornar objeto Usuario
            $usuario = new \Usuario(
                $fila['id'],
            );

            $this->conexion->cerrarConexion();
            return $usuario;
        }

        $this->conexion->cerrarConexion();
        return null;
    }


    public function insertar(Persona $usuario)
    {
        $this->conexion->abrirConexion();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $correo = $usuario->getEmail();
        $clave = $usuario->getClave();

        $sql = "INSERT INTO usuario (nombre, apellido, correo, clave, idRol)
                VALUES ('$nombre', '$apellido', '$correo', '$clave', 1)";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) {
            return $usuario;
        } else {
            echo "Hubo un fallo al agregar el usuario \n";
            return null;
        }
    }

    public function obtenerPorId($id)
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM usuario WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $usuario = null;

        if ($fila = $resultado->fetch_assoc()) {
            $usuario = new Persona($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave'], 1);
            // con este objeto de persona ya se esta llenando el constructor de la clase persona
        } else {
            echo "No se encontró el usuario por el ID\n";
        }

        $this->conexion->cerrarConexion();
        return $usuario;
    }

    public function obtenerPorCorreo($correo)
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM usuario WHERE correo = $correo";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $usuario = null;

        if ($fila = $resultado->fetch_assoc()) {
            $usuario = new Persona($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave'], 1);
            // con este objeto de persona ya se esta llenando el constructor de la clase persona
        } else {
            echo "No se encontró el usuario por el correo\n";
        }

        $this->conexion->cerrarConexion();
        return $usuario;
    }

    public function obtenerPorCorreoExcluyendoCorreoActual($id, $correo)
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM usuario WHERE(id != $id) AND (correo = '$correo')";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $usuario = null;

        if ($fila = $resultado->fetch_assoc()) {
            $usuario = new Persona($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave'], 1);
            // con este objeto de persona ya se esta llenando el constructor de la clase persona
        } else {
            echo "No se encontró el usuario por el correo \n";
        }

        $this->conexion->cerrarConexion();
        return $usuario;
    }

    public function listar()
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM usuario";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $usuarios = [];

        if (!$resultado) {
            $this->conexion->cerrarConexion();
            echo "Hubo un fallo al listar los usuarios \n";
            return null;
        }

        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = new Persona($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave'], 1);
        } // con este objeto de persona ya se esta llenando el constructor de la clase persona

        $this->conexion->cerrarConexion();
        return $usuarios;
    }

    public function actualizar(Persona $usuario)
    {
        $this->conexion->abrirConexion();
        $id = $usuario->getIdPersona();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $correo = $usuario->getEmail();
        $clave = $usuario->getClave();

        $sql = "UPDATE usuario 
                SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', clave = '$clave' 
                WHERE id = $id";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) {
            echo "Usuario actualizado correctamente\n";
            return $resultado;
        } else {
            echo "No se pudo actualizar el usuario\n";
            return null;
        }
    }

    public function eliminar($id)
    {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM usuario WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) {
            echo "Usuario con ID = $id eliminado correctamente\n";
            return $resultado;
        } else {
            echo "Usuario con ID = $id no se pudo eliminar\n";
            return null;
        }
    }
}
