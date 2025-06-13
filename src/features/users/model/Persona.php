<?php

namespace model;
use Rol;

class Persona
{
    protected $idPersona;
    protected $nombre;
    protected $apellido;
    protected $correo;
    protected $clave;
    protected Rol $rol;

    public function __construct($idPersona, $nombre, $apellido, $correo, $clave, $rol){
        $this -> idPersona = $idPersona;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
        $this -> rol = $rol;
    }

    public function getIdPersona(){
        return $this -> idPersona;
    }
    public function getNombre(){
        return $this -> nombre;
    }
    public function getApellido(){
        return $this -> apellido;
    }
    public function getCorreo(){
        return $this -> correo;
    }
    public function getClave(){
        return $this -> clave;
    }
    public function getRol(): Rol {
        return $this->rol;
    }

    public function setIdPersona($idPersona) {
        $this -> idPersona = $idPersona;
    }
    public function setNombre($nombre){
        $this -> nombre = $nombre;
    }
    public function setApellido($apellido){
        $this -> apellido = $apellido;
    }
    public function setCorreo($correo){
        $this -> correo = $correo;
    }
    public function setClave($clave){
        $this -> clave = $clave;
    }
}
?>