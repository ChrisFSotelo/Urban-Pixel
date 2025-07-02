<?php
namespace model;
class Producto{
    private int $id;
    private string $nombre;
    private int $cantidad;
    private int $precio;
    private Categoria $categoria;
    private int $estado;
    private $descripcion;
    private $datosImagen;
    private $nombreImagen;
    private $tipoImagen;

    public function __construct(int $id, string $nombre, int $cantidad, int $precio, Categoria $categoria, $estado, 
        $descripcion, $datosImagen, $nombreImagen, $tipoImagen) {
        
        $this->id = $id;
        $this->nombre = $nombre;
        $this->cantidad = $cantidad;
        $this->precio = $precio;
        $this->categoria= $categoria;
        $this->estado = $estado;
        $this->descripcion = $descripcion;
        $this->datosImagen = $datosImagen;
        $this->nombreImagen = $nombreImagen;
        $this->tipoImagen = $tipoImagen;
    }

    // Getters
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

    public function getEstado():int 
    {
        return $this->estado;
    }

    public function getDescripcion() 
    {
        return $this->descripcion;
    }

    public function getDatosImagen() 
    {
        return $this->datosImagen;
    }
    public function getNombreImagen() 
    {
        return $this->nombreImagen;
    }
    public function getTipoImagen() 
    {
        return $this->tipoImagen;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setCantidad(int $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function setCategoria(Categoria $categoria): void
    {
        $this->categoria = $categoria;
    }

    public function setEstado(int $estado): void
    {
        $this->estado = $estado;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setDatosImagen($datosImagen): void
    {
        $this->datosImagen = $datosImagen;
    }

    public function setNombreImagen(string $nombreImagen): void
    {
        $this->nombreImagen = $nombreImagen;
    }

    public function setTipoImagen(string $tipoImagen): void
    {
        $this->tipoImagen = $tipoImagen;
    }
}
