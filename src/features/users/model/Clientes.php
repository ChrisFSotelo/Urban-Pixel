<?php

namespace model;

use Rol;

class Clientes
{
    private int $id;
    private string $nombre;
    private string $apellido;
    private string $correo;
    private string $clave;
    private Rol $idRol;


    public function __construct(int $id, string $nombre, string $apellido, string $correo, string $clave, Rol $idRol)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->idRol = $idRol;
    }

    //Getters
    public function getId()
    {
        return $this->id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getApellido()
    {
        return $this->apellido;
    }
    public function getCorreo(){
        return $this->correo;
    }
    public function getClave(){
        return $this->clave;
    }
    public function getIdRol(){
        return $this->idRol;
    }

    //Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function setClave($clave)
    {
        $this->clave = $clave;
    }
    public function setIdRol($idRol){
        $this->idRol = $idRol;
    }


}

