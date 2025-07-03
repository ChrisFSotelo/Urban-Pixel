<?php

namespace model;

use DateTime;

class Factura {
    private int $id;
    private string $fecha;
    private string $hora;
    private int $subtotal;
    private float $iva;
    private int $total;
    private int $idCliente;
    private string $ciudad;
    private string $direccion;
    private int $estado;

    // Constructor
    public function __construct(int $id, string $fecha, string $hora, int $subtotal,
                                float $iva, int $total, int $idCliente, string $ciudad, string $direccion, int $estado) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->subtotal = $subtotal;
        $this->iva = $iva;
        $this->total = $total;
        $this->idCliente = $idCliente;
        $this->ciudad = $ciudad;
        $this->direccion = $direccion;
        $this->estado = $estado;
    }

    // Getters
    public function getId(): int {
        return $this->id;
    }
    public function getFecha(): string {
        return $this->fecha;
    }
    public function getHora(): string {
        return $this->hora;
    }
    public function getSubtotal(): int {
        return $this->subtotal;
    }
    public function getIva(): float {
        return $this->iva;
    }
    public function getTotal() {
        return $this->total;
    }
    public function getIdCliente(): int {
        return $this->idCliente;
    }
    public function getCiudad(): string {
        return $this->ciudad;
    }
    public function getDireccion(): string {
        return $this->direccion;
    }
    public function getEstado(): int {
        return $this->estado;
    }

    // Setters
    public function setId(int $id) {
        $this->id = $id;
    }
    public function setFecha(string $fecha) {
        $this->fecha = $fecha;
    }
    public function setHora(string $hora) {
        $this->hora = $hora;
    }
    public function setSubtotal(int $subtotal) {
        $this->subtotal = $subtotal;
    }

    public function setIva(float $iva) {
        $this->iva = $iva;
    }
    public function setTotal(int $total) {
        $this->total = $total;
    }
    public function setIdCliente(int $idCliente) {
        $this->idCliente = $idCliente;
    }
    public function setCiudad(string $ciudad) {
        $this->ciudad = $ciudad;
    }
    public function setDireccion(string $direccion) {
        $this->direccion = $direccion;
    }
    public function setEstado(string $estado) {
        $this->estado = $estado;
    }
}
?>