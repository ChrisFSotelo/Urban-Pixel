<?php
namespace model;
class Producto{
    private int $id;
    private string $nombre;
    private int $cantidad;
    private int $precio;
    private Categoria $categoria;

    public function __construct(int $id, string $nombre, int $cantidad, int $precio, Categoria $categoria)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->categoria= $categoria;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function getCategoria(): Categoria
    {
        return $this->categoria;
    }



}
