<?php
    require_once __DIR__ . '/init.php'; //carga la configuracion inicial del sistema
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\RESOURCES\Resources;
    $api = new Resources('resource_hub'); //Crea una instancia de la clase Resources para manejar los recursos
    $api->single($_GET['id'] ?? 0); //Obtiene un recurso específico según el ID proporcionado
    echo $api->getData(); //Devuelve la respuesta por resources en formato JSON
?>