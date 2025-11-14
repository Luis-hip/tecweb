<?php
    /*include_once __DIR__.'/database.php';

    $data = array();

    if(isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM productos WHERE id = {$id} AND eliminado = 0";
        if ( $result = $conexion->query($sql) ) {
            $row = $result->fetch_assoc();
            if(!is_null($row)) {
                foreach($row as $key => $value) {
                    $data[$key] = utf8_encode($value);
                }
            }
            $result->free();
        } else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    } 
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/

    use TECWEB\PRACTICA12\MYAPI\Read\Read as Read;
    require_once __DIR__ . '/vendor/autoload.php';

    $prodObj = new Read('marketzone');

    //Obtener el ID 
    $id = $_GET['id'] ?? 0;
    $prodObj->single(intval($id));
    
    echo $prodObj->getData();

?>