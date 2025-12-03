<?php
namespace TECWEB\PROYECTO\DATA;

abstract class Database{
    protected $data;
    protected $conexion;

    public function __construct($db, $user='root', $pass='05-Miphp530'){
        $this->data = array(); //Inicializa la variable data como un array vacío
        //Creamos la conexión a la base de datos
        $this->conexion = @mysqli_connect(
            'localhost',
            $user,
            $pass,
            $db
        );
    }

    //Devuelve los datos de this->data en formato JSON 
    public function getData(){
        return json_encode($this->data, JSON_PRETTY_PRINT); //JSON_PRETTY_PRINT para que sea legible
    }

    public function close(){
        $this->conexion->close();
    }
}


?>