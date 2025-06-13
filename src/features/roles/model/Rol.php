<?php 
    namespace model;
    
    class Rol {
        private int $id; 
        private string $nombre;
        
        // Constructor
        public function __construct(int $id, string $nombre) {
            $this->id = $id;
            $this->nombre = $nombre;
        }

        // Getters
        public function getId(): int {
            return $this->id;
        }
        public function getNombre(): string {
            return $this->nombre;
        }

        // Setters
        public function setId(int $id) {
            $this->id = $id;
        }
        public function setNombre(string $nombre) {
            $this->nombre = $nombre;
        }
    }
?>