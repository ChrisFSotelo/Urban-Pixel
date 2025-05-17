<?php

namespace dao;

class UsuarioDAO
{
    private $idPersona;
    private $nombre;
    private $apellido;
    private $email;
    private $clave;
    private $rol;

    public function __construct($idPersona=null, $nombre=null, $apellido=null, $email=null, $clave=null)
    {
        $this->idPersona = $idPersona;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->clave = $clave;
    }

    public function autenticarUsuario()
    {
        return "SELECT idUsuario FROM usuarios
                WHERE email = '. $this->email .' AND clave = '. $this->clave .'";
    }

}