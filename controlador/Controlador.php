<?php

class Controlador {
    
    public function __construct() {
        
    }
    
    public static function lista_resultado() {
        $con = new Conexion();
        $con->Conectar();
        $query = "Select * From dato";
        $resultados = $con->ConsultarBD($query);
        $con->CerrarConexion();
        return $resultados;
    }
}
