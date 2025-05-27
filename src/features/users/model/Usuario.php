<?php

    require_once __DIR__. "/Persona.php";
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

    public function __construct($idPersona = 0, $nombre = "", $apellido = "", $correo = "", $clave = "")
    {
        parent::__construct($idPersona, $nombre, $apellido, $correo, $clave);
    }
    public function autenticarUsuario()
    {
        $conexion = new Conexion();
        $conexion->abrirConexion();

        $usuarioDAO = new UsuarioDAO();
        $sql = $usuarioDAO->autenticarUsuario($this->correo, $this->clave);

//        echo "Consulta ejecutada: $sql <br>";
        $conexion->ejecutarConsulta($sql);

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