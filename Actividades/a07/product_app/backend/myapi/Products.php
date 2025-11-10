<?php
namespace TECWEB\MYAPI;

use mysqli;
use TECWEB\MYAPI\DataBase as dataBase;
require_once __DIR__ . '/DataBase.php';

class Products extends dataBase{
    private $data = null;

    public function __construct($user='root', $pass='05-Miphp530', $db){
        $this->data = array();
        parent::__construct($user, $pass, $db);
    }

    public function add($add){
        // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
        $producto = file_get_contents('php://input');
        $this->data = array(
            'status'  => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );
        if(!empty($producto)) {
            // SE TRANSFORMA EL STRING DEL JASON A OBJETO
            $jsonOBJ = json_decode($producto);
            // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
            $sql = "SELECT * FROM productos WHERE nombre = '{$jsonOBJ->nombre}' AND eliminado = 0";
            $result = $this->conexion->query($sql);
            
            if ($result->num_rows == 0) {
                $this->conexion->set_charset("utf8");
                $sql = "INSERT INTO productos VALUES (null, '{$jsonOBJ->nombre}', '{$jsonOBJ->marca}', '{$jsonOBJ->modelo}', {$jsonOBJ->precio}, '{$jsonOBJ->detalles}', {$jsonOBJ->unidades}, '{$jsonOBJ->imagen}', 0)";
                if($this->conexion->query($sql)){
                    $this->data['status'] =  "success";
                    $this->data['message'] =  "Producto agregado";
                } else {
                    $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
                }
            }

            $result->free();
            // Cierra la conexion
            $this->conexion->close();
        }
    }

    public function delete($id){
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        // SE VERIFICA HABER RECIBIDO EL ID
        if( isset($_GET['id']) ) {
            $id = $_GET['id'];
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
            if ( $this->conexion->query($sql) ) {
                $this->data['status'] =  "success";
                $this->data['message'] =  "Producto eliminado";
            } else {
                $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }
            $this->conexion->close();
        } 
    }

    public function edit($edit){
        // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
        $producto = file_get_contents('php://input');
        $this->data = array(
            'status'  => 'error',
            'message' => 'La consulta falló'
        );
        if(!empty($producto)) {
            // SE TRANSFORMA EL STRING DEL JASON A OBJETO
            $jsonOBJ = json_decode($producto);
            // SE ASUME QUE LOS DATOS YA FUERON VALIDADOS ANTES DE ENVIARSE
            $sql = "UPDATE productos SET 
                    nombre = '{$jsonOBJ->nombre}', 
                    marca = '{$jsonOBJ->marca}', 
                    modelo = '{$jsonOBJ->modelo}', 
                    precio = {$jsonOBJ->precio}, 
                    detalles = '{$jsonOBJ->detalles}', 
                    unidades = {$jsonOBJ->unidades} 
                WHERE id = {$jsonOBJ->id} AND eliminado = 0";
            
            $this->conexion->set_charset("utf8");
            if($this->conexion->query($sql)){
                $data['status'] =  "success";
                $data['message'] =  "Producto actualizado exitosamente";
            } else {
                $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
            }

            $this->conexion->close();
        }
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
                        $this->data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        }
        else{
            die('Quer Error: '.mysqli_error($this->conexion));
        }
        $this->conexion->close();
    }

    public function search($search){
        // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
        $this->data = array();
        // SE VERIFICA HABER RECIBIDO EL ID
        if( isset($_GET['search']) ) {
            $search = $_GET['search'];
            // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
            $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
            if ( $result = $this->conexion->query($sql) ) {
                // SE OBTIENEN LOS RESULTADOS
                $rows = $result->fetch_all(MYSQLI_ASSOC);

                if(!is_null($rows)) {
                    // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                    foreach($rows as $num => $row) {
                        foreach($row as $key => $value) {
                            $this->data[$num][$key] = utf8_encode($value);
                        }
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function single($single){
        $this->data = array();

        if(isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $sql = "SELECT * FROM productos WHERE id = {$id} AND eliminado = 0";
            if ( $result = $this->conexion->query($sql) ) {
                $row = $result->fetch_assoc();
                if(!is_null($row)) {
                    foreach($row as $key => $value) {
                        $data[$key] = utf8_encode($value);
                    }
                }
                $result->free();
            } else {
                die('Query Error: '.mysqli_error($this->conexion));
            }
            $this->conexion->close();
        }
    }

    public function checkName($name){
        $this->data = array(
            'exists' => false,
            'error' => ''
        );

        $this->conexion->set_charset("utf8mb4");

        if(isset($_GET['name'])){
            $name = $this->conexion->real_escape_string($_GET['name']);
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

            //Buscar si existe otro producto con el mismo nombre, que no sea el mismo id (en caso de edicion)
            $query = "SELECT * FROM productos
                    WHERE nombre = '{$name}' 
                    AND id != {$id}
                    AND eliminado = 0";

            if($result = $this->conexion->query($query)){
                if($result->num_rows > 0){
                    $data['exists'] = true;
                }
            } else {
                $data['error'] = 'Error en la consulta a la base de datos: '. $this->conexion->error;
            }
            $this->conexion->close();
        }
    }

    public function getData(){
        return json_encode($this->data, JSON_PRETTY_PRINT);
    }
}
?>