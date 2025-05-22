<?php
    // ***** ***** ***** *****
    // Clase por modificar :)
    // ***** ***** ***** *****

    class Ventas {
        private int $id;
        private Usuario $idUsuario; // Hace referencia al objeto 'Usuario', una usuario por venta
        private DateTime $fechaCompra;
        private int $total;

        // Constructor
        public function __construct(int $id, Usuario $idUsuario, DateTime $fechaCompra, int $total) {
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
        public function setId(int $id) {
            $this->id = $id;
        }
        public function setIdUsuario(Usuario $idUsuario) {
            $this->idUsuario = $idUsuario;
        }
        public function setFechaCompra(DateTime $fechaCompra) {
            $this->fechaCompra = $fechaCompra;
        }
        public function setTotal(int $total) {
            $this->total = $total;
        }
    }
?>