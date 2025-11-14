<?php
    /*include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');
    $data = array(
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
        
        $conexion->set_charset("utf8");
        if($conexion->query($sql)){
            $data['status'] =  "success";
            $data['message'] =  "Producto actualizado exitosamente";
        } else {
            $data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($conexion);
        }

        $conexion->close();
    }
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);*/

    use TECWEB\PRACTICA12\MYAPI\Update as Update;
    require_once __DIR__ . '/vendor/autoload.php';

    $prodObj = new Update('marketzone');
    //Obtener el JSON del cuerpo de la solicitud
    $json = file_get_contents('php://input');
    $prodObj->edit($json);
    echo $prodObj->getData();
?>