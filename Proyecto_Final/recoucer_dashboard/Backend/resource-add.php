<?php
    require_once __DIR__ . '/init.php'; //carga la configuracion inicial del sistema
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\RESOURCES\Resources;
    $api = new Resources('resource_hub'); //Crea una instancia de la clase Resources para manejar los recursos
    $api->agregar(file_get_contents('php://input')); //Lee los datos enviados desde el frontend para agregar un recurso
    echo $api->getData(); //Devuelve la respuesta por resources en formato JSON
?>