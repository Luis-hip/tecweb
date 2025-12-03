<?php
    require_once __DIR__ . '/init.php'; //carga la configuracion inicial del sistema
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\AUTH\Auth;
    $api = new Auth('resource_hub'); //Crea una instancia de la clase Auth para manejar el registro
    $api->registrarse(file_get_contents('php://input')); //Lee los datos enviados desde el frontend para registrarse
    echo $api->getData(); //Devuelve la respuesta por auth en formato JSON
?>