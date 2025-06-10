<?php

class Product
{
    private int $id;
    private string $nombre;
    private int $cantidad;
    private int $precio;
    private Categoria $idCategoria;
    private Usuario $idAdministrador;

    public function __construct(int $id, string $nombre, int $cantidad, int $precio)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
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
        return $this->idCategoria;
    }

    public function getAdministrador(): Usuario
    {
        return $this->idAdministrador;
    }
}
