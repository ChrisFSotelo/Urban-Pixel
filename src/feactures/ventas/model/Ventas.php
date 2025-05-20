<?php
    // ***** ***** ***** *****
    // Clase por modificar :)
    // ***** ***** ***** *****

    class Ventas {
        private $id;
        private Usuario $idUsuario; // Hace referencia al objeto 'Usuario', una usuario por venta
        private $fechaCompra;
        private $total;

        // Constructor
        public function __construct($id, Usuario $idUsuario, $fechaCompra, $total) {
            $this->id = $id;
            $this->idUsuario = $idUsuario;
            $this->fechaCompra = $fechaCompra;
            $this->total = $total;
        }

        // Getters
        public function getId() {
            return $this->id;
        }
        public function getIdUsuario(): Usuario {
            return $this->idUsuario;
        }
        public function getFechaCompra() {
            return $this->fechaCompra;
        }
        public function getTotal() {
            return $this->total;
        }

        // Setters
        public function setId($id) {
            $this->id = $id;
        }
        public function setIdUsuario(Usuario $idUsuario) {
            $this->idUsuario = $idUsuario;
        }
        public function setFechaCompra($fechaCompra) {
            $this->fechaCompra = $fechaCompra;
        }
        public function setTotal($total) {
            $this->total = $total;
        }
    }
?>