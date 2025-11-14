<?php 
namespace TECWEB\PRACTICA12\MYAPI;

use TECWEB\PRACTICA12\MYAPI\DataBase as DataBase;

class Update extends DataBase{
    public function __construct($db, $user='root', $pass='05-Miphp530'){
        parent::__construct($user, $pass, $db);
    }

    public function edit($edit){
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        if(!empty($edit)) {
            $jsonOBJ = json_decode($edit);

            // Escapamos los valores
            $nombre = $this->conexion->real_escape_string($jsonOBJ->nombre);
            $marca = $this->conexion->real_escape_string($jsonOBJ->marca);
            $modelo = $this->conexion->real_escape_string($jsonOBJ->modelo);
            $detalles = $this->conexion->real_escape_string($jsonOBJ->detalles);
            $precio = floatval($jsonOBJ->precio);
            $unidades = intval($jsonOBJ->unidades);
            $id = intval($jsonOBJ->id);
            
            $sql = "UPDATE productos SET 
                    nombre = '{$nombre}', 
                    marca = '{$marca}', 
                    modelo = '{$modelo}', 
                    precio = {$precio}, 
                    detalles = '{$detalles}', 
                    unidades = {$unidades} 
                WHERE id = {$id} AND eliminado = 0";
            
            if($this->conexion->query($sql)){
                $this->data['status'] =  "success";
                $this->data['message'] =  "Producto actualizado exitosamente";
            } else {
                $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
        }
        // Cierra la conexion AL FINAL
        $this->conexion->close();
    }
}
?>