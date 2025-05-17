<?php

use dao\UsuarioDAO;

class Usuario extends Persona
{
public function __construct($idPersona, $nombre, $apellido, $email, $clave){
    parent::__construct($idPersona, $nombre, $apellido, $email, $clave);
}

public function autenticarUsuario()
{
    $conexion = new Conexion();
    $conexion->abrirConexion();

    $usuarioDAO = new UsuarioDAO(null, null, null, $this->email, $this->clave);
    $conexion-> ejecutarConsulta($usuarioDAO->autenticarUsuario());
    if ($conexion->numeroFilas() == 0) {
        $conexion->cerrarConexion();
        return false;
    }else{
        $registro = $conexion->siguienteRegistro();
        $this->idPersona = $registro[0];
        $conexion->cerrarConexion();
        return true;
    }

}
}