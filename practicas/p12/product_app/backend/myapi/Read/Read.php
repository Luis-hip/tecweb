<?php 
namespace TECWEB\PRACTICA12\MYAPI\Read;

use TECWEB\PRACTICA12\MYAPI\DataBase as DataBase;

class Read  extends DataBase{
    public function __construct($db, $user='root', $pass='05-Miphp530'){
        parent::__construct($user, $pass, $db);
    }
    
    public function list(){
        //Se crea el arreglo que se va a devolver en forma de JSON
        $this->data = array();

        //Se realiza la query de busqueda y al mismo tiempo se valida si hubo resultado
        if($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")){
            //Se obtinen los resultados 
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(!is_null($rows)){
                //Se codifica a UTF-8 los datos y se mapea el arreglo de respuesta 
                foreach($rows as $num => $row){
                    foreach($row as $key => $value){
                        $this->data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        }
        else{
            $this->data['error'] = 'Query Error: '.mysqli_error($this->conexion);
        }
        $this->conexion->close();
    }

    public function search($search){
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array();
        if( !empty($search) ) {
            $safe_search = $this->conexion->real_escape_string($search);
            
            $sql = "SELECT * FROM productos WHERE (id = '{$safe_search}' OR nombre LIKE '%{$safe_search}%' OR marca LIKE '%{$safe_search}%' OR detalles LIKE '%{$safe_search}%') AND eliminado = 0";
            
            if ( $result = $this->conexion->query($sql) ) {
                $rows = $result->fetch_all(MYSQLI_ASSOC);
                if(!is_null($rows)) {
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
            } else {
                $this->data['error'] = 'Query Error: '.mysqli_error($this->conexion);
            }
        }
        // Cierra la conexion AL FINAL
        $this->conexion->close();
    }

    public function single($id){
        $this->data = array();
        $safe_id = intval($id);

        if($safe_id > 0) {
            $sql = "SELECT * FROM productos WHERE id = {$safe_id} AND eliminado = 0";
            if ( $result = $this->conexion->query($sql) ) {
                $row = $result->fetch_assoc();
                if(!is_null($row)) {
                    foreach($row as $key => $value) {
                        $this->data[$key] = utf8_encode($value);
                    }
                }
                $result->free();
            } else {
                $this->data['error'] = 'Query Error: '.mysqli_error($this->conexion);
            }
        }
        // Cierra la conexion AL FINAL
        $this->conexion->close();
    }

    public function checkName($name, $id){
        $this->data = array(
            'exists' => false,
            'error' => ''
        );

        if(!empty($name)){
            $safe_name = $this->conexion->real_escape_string($name);
            $safe_id = intval($id);

            $query = "SELECT * FROM productos
                      WHERE nombre = '{$safe_name}' 
                      AND id != {$safe_id}
                      AND eliminado = 0";

            if($result = $this->conexion->query($query)){
                if($result->num_rows > 0){
                    $this->data['exists'] = true;
                }
            } else {
                $this->data['error'] = 'Error en la consulta a la base de datos: '. $this->conexion->error;
            }
        }
        // Cierra la conexion AL FINAL
        $this->conexion->close();
    }
}
?>