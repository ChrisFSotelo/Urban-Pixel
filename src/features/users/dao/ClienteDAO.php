<?php

namespace dao;

require_once __DIR__ . "/../../../../config/Conexion.php";
require_once __DIR__ . "/../model/Clientes.php";


use Conexion;
use model\Clientes;

class ClienteDAO{
    private $conexion;

    public function __construct() {
        $this->conexion = new Conexion();
    }

    public function listar() {
        $this->conexion->abrirConexion();

        $sql = "SELECT * FROM cliente";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $clientes = [];

        while($fila = $resultado->fetch_assoc())
            $clientes[] = $fila;

        $this->conexion->cerrarConexion();
        return $clientes;
    }

    public function RegistrarCliente(Clientes $cliente) {
        $this->conexion->abrirConexion();
        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $correo = $cliente->getCorreo();
        $clave = $cliente->getClave();
        $idRol = $cliente->getIdRol();
        $estado = $cliente->getEstado() ? 1 : 0;
        $sql = "INSERT INTO cliente (nombre, apellido, correo, clave, idRol, estado) 
                                VALUES ('$nombre','$apellido','$correo','$clave',$idRol,$estado)";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        if ($resultado)
            return $cliente;

        echo ("Hubo un error al registrar el cliente");
        return null;

    }

    public function obtenerPorId($id) {
        $this->conexion->abrirConexion();
        $sql = "SELECT * FROM cliente WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if(!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            return null;
        }

        if($fila = $resultado->fetch_assoc()) {
            $this->conexion->cerrarConexion();
            return $fila;
        }

        $this->conexion->cerrarConexion();
        return null;
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

        if(!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un error al obtener el correo del cliente \n");
            return null;
        }

        if($fila = $resultado->fetch_assoc()) {
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
                SELECT * FROM usuario 
                UNION ALL 
                SELECT * FROM cliente WHERE id != $id
            ) AS combinado 
            WHERE correo = '$correo'";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if(!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al obtener el cliente Actual \n");
            return null;
        }

        if($fila = $resultado->fetch_assoc()) {
            $this->conexion->cerrarConexion();
            return $fila;
        }

        $this->conexion->cerrarConexion();
        return null;
    }

    public function actualizar(Clientes $cliente) {
        $this->conexion->abrirConexion();

        $id = $cliente->getId();
        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $correo = $cliente->getCorreo();
        $clave = $cliente->getClave();

        $sql = "UPDATE cliente SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', clave = '$clave' WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if(!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al actualizar el cliente \n");
            return null;
        }

        $this->conexion->cerrarConexion();
        return $resultado;
    }

    public function actualizarEstado($id, $nuevoEstado) {
        $this->conexion->abrirConexion();

        $sql = "UPDATE cliente SET estado = $nuevoEstado WHERE id = $id";

        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();

        return $resultado;
    }



    public function eliminar($id) {
        $this->conexion->abrirConexion();

        $sql = "DELETE FROM clientes WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $this->conexion->cerrarConexion();
        return $resultado;
    }

    public function AutenticarCliente($correo, $clave) {
        $this->conexion->abrirConexion();

        $sql = "SELECT id, nombre, apellido, correo, clave,idRol, estado 
        FROM cliente 
        WHERE correo = '$correo' AND clave = '$clave'";


        $resultado = $this->conexion->ejecutarConsulta($sql);

        if ($resultado && $resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();

            // Crear y retornar objeto Cliente
            $cliente = new Clientes(
                $fila['id'],
                $fila['nombre'],
                $fila['apellido'],
                $fila['correo'],
                $fila['clave'],
                $fila['idRol'],
                $fila['estado']
            );


            $this->conexion->cerrarConexion();
            return $cliente;
       }

        $this->conexion->cerrarConexion();
        return null;
    }
}