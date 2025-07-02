<?php
namespace dao;

require_once __DIR__ . "/../../../../config/Conexion.php";

use Conexion;
use Usuario;

class UsuarioDAO {
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function AutenticarUsuario($correo, $clave) {
        $this->conexion->abrirConexion();

        $sql = "SELECT * FROM usuario WHERE correo = '$correo' AND clave = '$clave'";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if($fila = $resultado->fetch_assoc())
            return $fila;

        return null;
    }

    public function registarAdmin(Usuario $usuario) {
        $this->conexion->abrirConexion();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $correo = $usuario->getCorreo();
        $clave = $usuario->getClave();
        $idRol = $usuario->getRol();
        $estado = $usuario->getEstado() ? 1 : 0;

        $sql = "INSERT INTO usuario (nombre, apellido, correo, clave, idRol, idEstado) 
                                VALUES ('$nombre','$apellido','$correo','$clave',$idRol,$estado)";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado)
            return $usuario;

        echo ("Hubo un error al registrar el usuario");
        return null;
    }

    public function obtenerPorId($id) {
        $this->conexion->abrirConexion();

        $sql = "SELECT * FROM usuario WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $usuario = null;

        if(!$resultado) {
            $this->conexion->cerrarConexion();
            return null;
        }

        if($fila = $resultado->fetch_assoc())
            $usuario = $fila;

        $this->conexion->cerrarConexion();
        return $usuario;
    }

    public function obtenerPorCorreo($correo) {
        $this->conexion->abrirConexion();
        $sql =
            "SELECT * FROM (
                SELECT * FROM usuario 
                UNION ALL 
                SELECT * FROM cliente
            ) AS combinado 
            WHERE correo = '$correo'";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo ("Hubo un error al obtener el correo del cliente \n");
            return null;
        }

        if ($fila = $resultado->fetch_assoc()) {
            $this->conexion->cerrarConexion();
            return $fila;
        }

        $this->conexion->cerrarConexion();
        return null;
    }

    public function obtenerPorCorreoExcluyendoActual($id, $correo) {
        $this->conexion->abrirConexion();
        $sql =
            "SELECT * FROM (
                SELECT * FROM usuario WHERE id != $id 
                UNION ALL 
                SELECT * FROM cliente
            ) AS combinado 
            WHERE correo = '$correo'";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if (!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo ("Hubo un fallo al obtener el cliente Actual \n");
            return null;
        }

        if ($fila = $resultado->fetch_assoc()) {
            $this->conexion->cerrarConexion();
            return $fila;
        }

        $this->conexion->cerrarConexion();
        return null;
    }


    public function listar() {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM usuario";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $usuarios = [];

        if (!$resultado) {
            $this->conexion->cerrarConexion();
            echo "Hubo un fallo al listar los usuarios \n";
            return null;
        }

        while($fila = $resultado->fetch_assoc())
            $usuarios[] = $fila;

        $this->conexion->cerrarConexion();
        return $usuarios;
    }

    public function listarExcluyendoActual(int $idAdmin) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM usuario WHERE id != $idAdmin";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $usuarios = [];

        if (!$resultado) {
            $this->conexion->cerrarConexion();
            return null;
        }

        while($fila = $resultado->fetch_assoc())
            $usuarios[] = $fila;

        $this->conexion->cerrarConexion();
        return $usuarios;
    }

    public function actualizar(Usuario $usuario) {
        $this->conexion->abrirConexion();

        $id = $usuario->getIdPersona();
        $nombre = $usuario->getNombre();
        $apellido = $usuario->getApellido();
        $correo = $usuario->getCorreo();
        $clave = $usuario->getClave();

        $sql = "UPDATE usuario 
                SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', clave = '$clave' 
                WHERE id = $id";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado)
            return $resultado;
        else {
            echo "No se pudo actualizar el usuario\n";
            return null;
        }
    }

    public function actualizarEstado($id, $nuevoEstado) {
        $this->conexion->abrirConexion();

        $sql = "UPDATE usuario SET idEstado = $nuevoEstado WHERE id = $id";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        return $resultado;
    }

    public function cambiarClave($id, $nuevaClave) {
        $this->conexion->abrirConexion();

        $sql = "UPDATE usuario SET clave = '$nuevaClave' WHERE id = $id";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if($resultado)
            return true;
        
        return false;
    }

    public function eliminar($id) {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM usuario WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if(!$resultado)
            return null;

        if($resultado)
            return $id;
        
        return null;
    }
}
