<?php
    require_once "../../clientes/model/Cliente.php";

    class Factura {
        private int $id;
        private DateTime $fecha;
        private DateTime $hora;
        private int $subtotal;
        private int $iva;
        private int $total;
        private Cliente $cliente;
        private string $ciudad;
        private string $direccion;

        // Constructor
        public function __construct(int $id, DateTime $fecha, DateTime $hora, int $subtotal, 
            int $iva, int $total, Cliente $cliente, string $ciudad, string $direccion) {

            $this->id = $id;
            $this->fecha = $fecha;
            $this->hora = $hora;
            $this->subtotal = $subtotal;
            $this->iva = $iva;
            $this->total = $total;
            $this->cliente = $cliente;
            $this->ciudad = $ciudad;
            $this->direccion = $direccion;
        }

        // Getters
        public function getId(): int {
            return $this->id;
        }
        public function getFecha(): DateTime {
            return $this->fecha;
        }
        public function getHora(): DateTime {
            return $this->hora;
        }
        public function getSubtotal(): int {
            return $this->subtotal;
        }
        public function getIva(): int {
            return $this->iva;
        }
        public function getTotal() {
            return $this->total;
        }
        public function getCliente(): Cliente {
            return $this->cliente;
        }
        public function getCiudad(): string {
            return $this->ciudad;
        }
        public function getDireccion(): string {
            return $this->direccion;
        }

        // Setters
        public function setId(int $id) {
            $this->id = $id;
        }
        public function setFecha(DateTime $fecha) {
            $this->fecha = $fecha;
        }
        public function setHora(DateTime $hora) {
            $this->hora = $hora;
        }
        public function setSubtotal(int $subtotal) {
            $this->subtotal = $subtotal;
        }
        public function setIva(int $iva) {
            $this->iva = $iva;
        }
        public function setTotal(int $total) {
            $this->total = $total;
        }
        public function setCliente(Cliente $cliente) {
            $this->cliente = $cliente;
        }
        public function setCiudad(string $ciudad) {
            $this->ciudad = $ciudad;
        }
        public function setDireccion(string $direccion) {
            $this->direccion = $direccion;
        }
    }
?>