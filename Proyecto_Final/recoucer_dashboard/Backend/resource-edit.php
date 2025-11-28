<?php
    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\RESOURCES\Resources;
    if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        die(json_encode(['status' => 'error']));
    }
    $api = new Resources('resource_hub');
    $api->editar(file_get_contents('php://input'));
    echo $api->getData();
?>