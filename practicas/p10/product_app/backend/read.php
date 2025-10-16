<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    
    //Busqueda por texto
    if(isset($_POST['search'])){ //Verificamos haber recibido un parámetro de búsqueda
        $search = $_POST['search'];
        $sql = "SELECT * FROM productos WHERE nombre LIKE '%$search%' OR marca LIKE '%$search%' OR detalles LIKE '%$search%' AND eliminado = 0";
        if($result = $conexion->query($sql)){
            // SE OBTIENEN LOS RESULTADOS y se mapenan 
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $data[] = $row;
            }
            $result->free();
        }
        else {
            die('Query Error: '.mysqli_error($conexion));
        }
        $conexion->close();
    }

    //Busqueda por ID 
    /*if( isset($_POST['id']) ) { // SE VERIFICA HABER RECIBIDO EL ID
        $id = $_POST['id'];
        // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
        if ( $result = $conexion->query("SELECT * FROM productos WHERE id = '{$id}'") ) {
            // SE OBTIENEN LOS RESULTADOS
			$row = $result->fetch_array(MYSQLI_ASSOC);

            if(!is_null($row)) {
                // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
                foreach($row as $key => $value) {
                    $data[$key] = $value; // utf8_encode($value);
                }
            }
			$result->free();
		} else {
            die('Query Error: '.mysqli_error($conexion));
        }
		$conexion->close();
    } */
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>

