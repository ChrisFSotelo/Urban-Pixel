<?php

namespace features\producto_factura\model;

use features\factura\model\Factura;
use Producto;

require_once "../../factura/model/Factura.php";
require_once "../../productos/model/Producto.php";

class ProductoFactura
{
    private Factura $factura;
    private Producto $producto;
    private int $cantidad;
    private int $precioVenta;

    // Constructor
    public function __construct(Factura $factura, Producto $producto, int $cantidad, int $precioVenta)
    {
        $this->factura = $factura;
        $this->producto = $producto;
        $this->cantidad = $cantidad;
        $this->precioVenta = $precioVenta;
    }

    // Getters
    public function getFactura(): Factura
    {
        return $this->factura;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
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
    public function setFactura(Factura $factura)
    {
        $this->factura = $factura;
    }

    public function setProducto(Producto $producto)
    {
        $this->producto = $producto;
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