<?php
    /*include_once __DIR__.'/database.php';

    $data = array(
        'exists' => false,
        'error' => ''
    );

    $conexion->set_charset("utf8mb4");

    if(isset($_GET['name'])){
        $name = $conexion->real_escape_string($_GET['name']);
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        //Buscar si existe otro producto con el mismo nombre, que no sea el mismo id (en caso de edicion)
        $query = "SELECT * FROM productos
                  WHERE nombre = '{$name}' 
                  AND id != {$id}
                  AND eliminado = 0";

        if($result = $conexion->query($query)){
            if($result->num_rows > 0){
                $data['exists'] = true;
            }
        } else {
            $data['error'] = 'Error en la consulta a la base de datos: '.$conexion->error;
        }
        $conexion->close();
    }
    //Devolver la respuesta en formato JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/

    use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('marketzon');
    //Obtenemos los parametros
    $name = $_GET['name'] ?? '';
    $id = $_GET['id'] ?? 0;
    $prodObj->checkName($name, $id);
    echo $prodObj->getData();
?>