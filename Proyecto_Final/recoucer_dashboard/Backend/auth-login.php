<?php
    require_once __DIR__ . '/init.php'; //carga la configuracion inicial del sistema
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\AUTH\Auth;
    //Crea una instancia de la clase Auth para manejar la autenticación
    $api = new Auth('resource_hub');
    //Lee los datos enviados desde el frontend para iniciar sesión
    $api->iniciarSesion(file_get_contents('php://input'));
    echo $api->getData(); //Devuelve la respuesta por auth en formato JSON
?>