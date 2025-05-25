<?php

namespace dao;

require_once "../../../../config/Conexion.php";
require_once "../model/Clientes.php";

use Conexion;
use model\Clientes;

class ClienteDAO{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    //insertar
    public function RegistrarCliente(Clientes $cliente)
    {
        $this->conexion->abrirConexion();
        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $correo = $cliente->getCorreo();
        $clave = $cliente->getClave();
        $idRol = $cliente->getIdRol();

        $sql = "INSERT INTO  cliente (nombre, apellido, correo, clave, idRol) VALUES ('$nombre','$apellido','$correo','$clave',$idRol)";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $this->conexion->cerrarConexion();
        if($resultado)
            return $cliente;

        echo ("Hubo un error al registrar el cliente");
        return null;
    }
//CONSULTAS POR PROBAR
    public function obtenerPorId($id){
        $this->conexion->abrirConexion();
        $sql = "SELECT  nombre, apellido, correo FROM clientes WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        if(!$resultado) { // Si hubo un error
            $this->conexion->cerrarConexion();
            echo("Hubo un fallo al obtener el cliente \n");
            return null;
        }

        if ($fila = $resultado ->fetch_assoc())
            $cliente = new Clientes($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave'], $fila['idRol']);
        $this->conexion->cerrarConexion();
        return $cliente;

    }

    public function actualizar(Clientes $cliente) {
        $this->conexion->abrirConexion();

        $id = $cliente->getId();
        $nombre = $cliente->getNombre();
        $apellido = $cliente->getApellido();
        $correo = $cliente->getCorreo();
        $clave = $cliente->getClave();

        $sql = "UPDATE clientes SET nombre = '$nombre', apellido = '$apellido', correo = '$correo', clave = '$clave'  WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $this->conexion->cerrarConexion();
        return $resultado;
    }

    public function listar() {
        $this->conexion->abrirConexion();

        $sql = "SELECT nombre, apellido, correo FROM clientes";
        $resultado = $this->conexion->ejecutarConsulta($sql);
        $clientes = [];

        while ($fila = $resultado->fetch_assoc())
            $clientes[] = new Clientes($fila['id'], $fila['nombre'], $fila['apellido'], $fila['correo'], $fila['clave'], $fila['idRol']);

        $this->conexion->cerrarConexion();
        return $clientes;
    }

    public function eliminar($id) {
        $this->conexion->abrirConexion();

        $sql = "DELETE FROM clientes WHERE id = $id";
        $resultado = $this->conexion->ejecutarConsulta($sql);

        $this->conexion->cerrarConexion();
        return $resultado;
    }

}