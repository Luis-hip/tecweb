<?php 
namespace TECWEB\PRACTICA12\MYAPI;

use mysqli;

abstract class  DataBase{
    protected $data;
    protected $conexion;

    public function __construct($user, $pass, $db){
        $this->data = array();
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );

        if(!$this->conexion){
            die('¡Base de datos NO conectada');
        }
    }

    public function getData(){
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}

?>