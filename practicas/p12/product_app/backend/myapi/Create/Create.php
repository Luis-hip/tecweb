<?php 
namespace TECWEB\PRACTICA12\MYAPI;

use TECWEB\PRACTICA12\MYAPI\DataBase as DataBase;

class Create extends DataBase{
    public function __construct($db, $user='root', $pass='05-Miphp530'){
        parent::__construct($user, $pass, $db);
    }

    public function add($add){
        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );
        if(!empty($add)) {
                $jsonOBJ = json_decode($add);

            // Escapamos los valores para seguridad
            $nombre = $this->conexion->real_escape_string($jsonOBJ->nombre);
            $marca = $this->conexion->real_escape_string($jsonOBJ->marca);
            $modelo = $this->conexion->real_escape_string($jsonOBJ->modelo);
            $detalles = $this->conexion->real_escape_string($jsonOBJ->detalles);
            $imagen = $this->conexion->real_escape_string($jsonOBJ->imagen);
            $precio = floatval($jsonOBJ->precio);
            $unidades = intval($jsonOBJ->unidades);

            $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);
            
            if ($result->num_rows == 0) {
                $sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";
                if($this->conexion->query($sql)){
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
            }
            $result->free();
        }
        // Cierra la conexion AL FINAL
        $this->conexion->close();    
    }

}
?>