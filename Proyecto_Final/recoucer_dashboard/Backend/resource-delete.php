<?php
    require_once __DIR__ . '/init.php'; //carga la configuracion inicial del sistema
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\RESOURCES\Resources;
    // Verifica si el usuario tiene rol de admin antes de permitir la eliminación
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        die(json_encode(['status' => 'error']));
    }
    $api = new Resources('resource_hub'); //Crea una instancia de la clase Resources para manejar los recursos
    $api->eliminar(file_get_contents('php://input')); //Lee los datos enviados desde el frontend para eliminar un recurso
    echo $api->getData(); //Devuelve la respuesta por resources en formato JSON
?>