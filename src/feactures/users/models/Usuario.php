<?php

use dao\UsuarioDAO;

class Usuario extends Persona
{
    private $productos;

    public function getProductos()
    {
        return $this->productos;
    }

    public function setProductos($productos)
    {
        $this->productos = $productos;
    }

    public function __construct($idPersona = 0, $nombre = "", $apellido = "", $email = "", $clave = "")
    {
        parent::__construct($idPersona, $nombre, $apellido, $email, $clave);
    }

    public function autenticarUsuario()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $usuarioDAO = new UsuarioDAO(null, null, null, $this->email, $this->clave);
        $conexion->ejecutarConsulta($usuarioDAO->autenticarUsuario());

//        DEBUG
//        $sql = $usuarioDAO->autenticarUsuario();
//        echo "Consulta ejecutada: $sql <br>"; // Te mostrará la consulta real
//        $conexion->ejecutarConsulta($sql);

        if ($conexion->numeroFilas() == 0) {
            $conexion->cerrarConexion();
            return false;
        } else {
            $registro = $conexion->siguienteRegistro();
            $this->idPersona = $registro[0];
            $conexion->cerrarConexion();
            return true;
        }

    }
}