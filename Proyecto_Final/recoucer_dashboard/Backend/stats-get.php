<?php
    require_once __DIR__ . '/init.php'; //carga la configuracion inicial del sistema
    require_once __DIR__ . '/vendor/autoload.php';
    use TECWEB\PROYECTO\Stats\Stats;
    // Verifica si el usuario tiene rol de admin antes de permitir el acceso a las estadísticas
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin'){
        die(json_encode(['status'=>'error']));
    }
    $api = new Stats('resource_hub'); //Crea una instancia de la clase Stats para manejar las estadísticas
    $api->getChartsData(); //Obtiene los datos para los gráficos estadísticos
    echo $api->getData(); //Devuelve la respuesta por stats en formato JSON
?>