<?php

class Conexion {
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;
    private $conection;
    
    public function __construct() {
        $this->db_host = "localhost";
        $this->db_name = "prueba";
        $this->db_user = "root";
        $this->db_password = "";
        $this->conection = NULL;
    }
    
    public function Conectar() {
        $this->conection = mysqli_connect($this->db_host, $this->db_user, $this->db_password, $this->db_name);
        mysqli_set_charset($this->conection, "utf8");
    }
    
    public function ConsultarBD($query) {
        $resultados = mysqli_query($this->conection, $query);
        return $resultados;
    }
    
    public function CerrarConexion() {
        mysqli_close($this->conection); 
    }
}
