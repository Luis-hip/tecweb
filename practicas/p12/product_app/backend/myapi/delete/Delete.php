<?php 
namespace TECWEB\PRACTICA12\MYAPI\Delete;

use TECWEB\PRACTICA12\MYAPI\DataBase as DataBase;

class Delete extends DataBase{
    public function __construct($db, $user='root', $pass='05-Miphp530'){
        parent::__construct($user, $pass, $db);
    }

    public function delete($id){
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );

        $safe_id = intval($id); // Limpia el ID que recibes como parámetro

        if( $safe_id > 0 ) {
            $sql = "UPDATE productos SET eliminado=1 WHERE id = {$safe_id}";
            if ( $this->conexion->query($sql) ) {
                $this->data['status'] =  "success";
                $this->data['message'] =  "Producto eliminado";
            } else {
                $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
        } 
        $this->conexion->close();
    }
}
?>