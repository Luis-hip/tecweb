<?php
    require_once __DIR__ . '/init.php';
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\AUTH\Auth;
    $api = new Auth('resource_hub');
    $api->iniciarSesion(file_get_contents('php://input'));
    echo $api->getData();
?>