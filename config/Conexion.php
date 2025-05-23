<?php
class Conexion
{
    private $mysqlConexion;
    private $resultado;

    public function abrirConexion()
    {
     $this->mysqlConexion = new mysqli("localhost","root","","urban_pixel");
     if ( $this->mysqlConexion->connect_error){
         die("Error al conectar con la base de datos". $this->mysqlConexion->connect_error);
     }
    }

    public function getConexion()
    {
        return $this->mysqlConexion;
    }

    public function cerrarConexion()
    {
        $this->mysqlConexion->close();
    }

        public function ejecutarConsulta($sql) {
            try {
                $this->resultado = $this->mysqlConexion->query($sql);
                return $this->resultado;
            }
            catch (Exception $e) {
                echo("Error al ejecutar la consulta: \n". $sql ."\n". $e->getMessage(). "\n");
                return false;
            }
        }

    public function siguienteRegistro()
    {
        return $this->resultado->fetch_row();
    }

    public function obtenerLlaveAutonumerica()
    {
        return $this->mysqlConexion->insert_id;
    }

    public function numeroFilas()
    {
        return $this->resultado->num_rows;

    }

}