<?php
    session_start(); //Inicia la sesión actual o reanuda la sesión previa
    session_unset(); //Elimina todas las variables de sesión
    session_destroy(); //Destruye la sesión actual
    echo json_encode(['status' => 'success']); //Devuelve una respuesta JSON indicando que el logout fue exitoso
?>