<?php 
    class Categoria {
        private $id;
        private $nombre;

        // Constructor
        public function __construct($id, $nombre) {
            $this->id = $id;
            $this->nombre = $nombre;
        }

        // Getters
        public function getId() {
            return $this->id;
        }
        public function getNombre() {
            return $this->nombre;
        }

        // Setters
        public function setId($id) {
            $this->id = $id;
        }
        public function setNombre($nombre) {
            $this->nombre = $nombre;
        }
    }
?>