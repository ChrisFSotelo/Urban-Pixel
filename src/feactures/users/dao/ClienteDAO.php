<?php
namespace dao;

require_once __DIR__ . '/../models/Persona.php';
require_once __DIR__ . '/../config/Conexion.php';

use models\Persona;

class ClienteDAO
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new \Conexion();
    }

    public function insertar(Persona $cliente)
    {
        $this->conexion->abrirConexion();
        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $correo = $cliente->getEmail();
        $clave = $cliente->getClave();

        $sql = "INSERT INTO cliente (nombre, apellido, correo, clave, idRol)
                VALUES ('$nombre', '$apellido', '$correo', '$clave', 2)"; 

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) {
            return $cliente;
        } else {
            echo "Hubo un fallo al agregar el cliente \n";
            return null;
        }
    }

    public function obtenerPorId($id)
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM cliente WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $cliente = null;

        if ($fila = $resultado->fetch_assoc()) {
            $cliente = new Persona($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave']);
        } else {
            echo "No se encontró el cliente por el ID\n";
        }

        $this->conexion->cerrarConexion();
        return $cliente;
    }

    public function listar()
    {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM cliente";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $clientes = [];

        if (!$resultado) {
            $this->conexion->cerrarConexion();
            echo "Hubo un fallo al listar los clientes \n";
            return null;
        }

        while ($fila = $resultado->fetch_assoc()) {
            $clientes[] = new Persona($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave']);
        }

        $this->conexion->cerrarConexion();
        return $clientes;
    }

    public function actualizar(Persona $cliente)
    {
        $this->conexion->abrirConexion();
        $id = $cliente->getIdPersona();
        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $correo = $cliente->getEmail();
        $clave = $cliente->getClave();

        $sql = "UPDATE cliente 
                SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', clave = '$clave' 
                WHERE id = $id";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) {
            echo "Cliente actualizado correctamente\n";
            return $resultado;
        } else {
            echo "No se pudo actualizar el cliente\n";
            return null;
        }
    }

    public function eliminar($id)
    {
        $this->conexion->abrirConexion();
        $sql = "DELETE FROM cliente WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado) {
            echo "Cliente con ID = $id eliminado correctamente\n";
            return $resultado;
        } else {
            echo "Cliente con ID = $id no se pudo eliminar\n";
            return null;
        }
    }
}
