<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        '05-Miphp530',
        'recoucer_hub'
    );

    if(!$conexion){
        die(json_encode(['status' => 'error', 'message' => 'Error de conexión a la base de datos']));
    }
?>