<?php
    header('Access-Control-Allow-Origin: *'); //Permite solicitudes desde cualquier origen
    header('Content-Type: application/json; charset=UTF-8'); //Indica que la respuesta será en formato JSON
    session_start(); //Inicia la sesión actual o reanuda la sesión previa
?>