<?php
    include_once __DIR__.'/database.php';

    // SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
    $producto = file_get_contents('php://input');

    $result = array();

    if(!empty($producto)) {
        // SE TRANSFORMA EL STRING DEL JASON A OBJETO
        $jsonOBJ = json_decode($producto);
        
        //Se valida si ya existe el producto
        $nombre = $jsonOBJ->nombre;
        $marca = $jsonOBJ->marca;
        $modelo = $jsonOBJ->modelo;

        $check_sql = "SELECT * FROM productos WHERE ((nombre = '$nombre' AND marca = '$marca') OR (marca = '$marca' AND modelo = '$modelo')) AND eliminado = 0";

        if($result = $conexion->query($check_sql)) {
            if($result->num_rows > 0) {
                //el producto ya existe
                $response['status'] = 'error';
                $response['message'] = 'El producto ya existe en la base de datos.';
            }
            else{
                //El producto no existe, se procede a insertarlo
                $precio = $jsonOBJ->precio;
                $detalles = $jsonOBJ->detalles;
                $unidades = $jsonOBJ->unidades;
                $imagen = $jsonOBJ->imagen;

                $insert_sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";

                if($conexion->query($insert_sql)){
                    $response['status'] = 'success';
                    $response['message'] = 'Producto insertado exitosamente.';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error al insertar el producto: '.$conexion->error;
                }
            }
            $result->free();
        }
        else{
            $response['status'] = 'error';
            $response['message'] = 'Error en la consulta: '.$conexion->error;
        }
        $conexion->close();
    }
    else{
        $response['status'] = 'error';
        $response['message'] = 'No se recibieron datos del producto.';
    }

    // SE ENVÍA LA RESPUESTA AL CLIENTE EN FORMATO JSON
    header('Content-Type: application/json');
    echo json_encode($response);
?>