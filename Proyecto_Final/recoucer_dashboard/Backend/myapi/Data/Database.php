<?php
namespace TECWEB\PROYECTO\DATA;

abstract class Database{
    protected $data;
    protected $conexion;

    public function __construct($db, $user='root', $pass='05-Miphp530'){
        $this->data = array();
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );
    }

    public function getData(){
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }

    public function close(){
        $this->conexion->close();
    }
}


?>