<?php 
    class Producto {
        private int $id;
        private string $nombre;
        private int $cantidad;
        private int $precio;
        private Categoria $categoria; // Hace referencia al objeto 'Categorias', una categoría por producto

        // Constructor
        public function __construct(int $id, string $nombre, int $cantidad, int $precio, Categoria $categoria) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->cantidad = $cantidad;
            $this->precio = $precio;
            $this->categoria = $categoria;
        }

        // Getters
        public function getId() {
            return $this->id;
        }
        public function getNombre() {
            return $this->nombre;
        }
        public function getCantidad() {
            return $this->cantidad;
        }
        public function getPrecio() {
            return $this->precio;
        }
        public function getCategoria(): Categoria {
            return $this->categoria;
        }

        // Setters
        public function setId(int $id) {
            $this->id = $id;
        }
        public function setNombre(string $nombre) {
            $this->nombre = $nombre;
        }
        public function setCantidad(int $cantidad) {
            $this->cantidad = $cantidad;
        }
        public function setPrecio(int $precio) {
            $this->precio = $precio;
        }
        public function setCategoria(Categoria $categoria) {
            $this->categoria = $categoria;
        }
    }
?>