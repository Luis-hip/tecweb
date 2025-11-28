<?php
    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\RESOURCES\Resources;
    $api = new Resources('resource_hub');
    $api->agregar(file_get_contents('php://input'));
    echo $api->getData();
?>