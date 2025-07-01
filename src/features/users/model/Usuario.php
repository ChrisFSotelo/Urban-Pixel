<?php

class Usuario {
    private $idPersona;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $estado;
    private $rol;

    public function __construct($idPersona, $nombre, $apellido, $correo, $clave, $estado, $rol){
        $this -> idPersona = $idPersona;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
        $this->estado = $estado;
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
    public function getRol(){
        return $this -> rol;
    }
    public function getEstado(){
        return $this->estado;
    }

    public function setIdPersona($idPersona)
    {
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
    public function setRol($rol){
        $this -> rol = $rol;
    }
    public function setEstado($estado){
        $this->estado = $estado;
    }
}