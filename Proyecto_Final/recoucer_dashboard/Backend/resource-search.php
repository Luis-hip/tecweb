<?php
    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\RESOURCES\Resources;
    $api = new Resources('resource_hub');
    $api->buscar($_GET['search'] ?? '');
    echo $api->getData();
?>