<?php 
namespace TECWEB\MYAPI;

use mysqli;

abstract class  DataBase{
    protected $conexion;

    public function __construct($user, $pass, $db){
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
}

?>