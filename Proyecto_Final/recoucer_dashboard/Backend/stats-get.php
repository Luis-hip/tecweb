<?php
    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\Stats\Stats;
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        die(json_encode(['status'=>'error']));
    }
    $api = new Stats('resource_hub');
    $api->getChartsData();
    echo $api->getData();
?>