<?php 
    class Producto {
        private $id;
        private $nombre;
        private $cantidad;
        private $precio;
        private Categoria $categoria; // Hace referencia al objeto 'Categorias', una categoría por producto

        // Constructor
        public function __construct($id, $nombre, $cantidad, $precio, Categoria $categoria) {
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
        public function setId($id) {
            $this->id = $id;
        }
        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }
        public function setCantidad($cantidad) {
            $this->cantidad = $cantidad;
        }
        public function setPrecio($precio) {
            $this->precio = $precio;
        }
        public function setCategoria(Categoria $categoria) {
            $this->categoria = $categoria;
        }
    }
?>