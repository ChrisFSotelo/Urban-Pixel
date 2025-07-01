<?php

namespace model;

class ProductoFactura
{
    private int $idFactura;
    private int $idProducto;
    private int $cantidad;
    private int $precioVenta;

    // Constructor
    public function __construct(int $idFactura, int $idProducto, int $cantidad, int $precioVenta)
    {
        $this->idFactura = $idFactura;
        $this->idProducto = $idProducto;
        $this->cantidad = $cantidad;
        $this->precioVenta = $precioVenta;
    }

    // Getters
    public function getIdFactura(): int
    {
        return $this->idFactura;
    }

    public function getIdProducto(): int
    {
        return $this->idProducto;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getPrecioVenta(): int
    {
        return $this->precioVenta;
    }

    // Setters
    public function setIdFactura(int $idFactura)
    {
        $this->idFactura = $idFactura;
    }

    public function setIdProducto(int $idProducto)
    {
        $this->idProducto = $idProducto;
    }

    public function setCantidad(int $cantidad)
    {
        $this->cantidad = $cantidad;
    }

    public function setPrecioVenta(int $precioVenta)
    {
        $this->precioVenta = $precioVenta;
    }
}

?>