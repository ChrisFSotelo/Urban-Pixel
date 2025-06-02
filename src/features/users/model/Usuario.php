<?php

use model\Persona;

require_once __DIR__. "/Persona.php";


class Usuario extends Persona{
    private $productos;

    public function getProductos()
    {
        return $this->productos;
    }

    public function setProductos($productos)
    {
        $this->productos = $productos;
    }

    public function __construct($idPersona = 0, $nombre = "", $apellido = "", $correo = "", $clave = "", $rol = 0)
    {
        parent::__construct($idPersona, $nombre, $apellido, $correo, $clave, $rol);
    }
}