<?php include 'src/funciones.php'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Práctica 6</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    <?php 
            @$numero = $_GET['numero'];
            echo esMultiploDe5y7($numero);
    ?>

    <h2>Ejercicio 2</h2>
    <p>Crear un programa para la generación repetitiva de 3 números aleatorios hasta obtener un secuencia compuesta por: impar, par, impar.</p>
    <?php secuenciaImparParImpar(); ?>

    <h2>Ejercicio 3</h2>
    <?php
        if(isset($_GET['numero'])){
            $numero = $_GET['numero'];
            echo "<p>EL múltiplo (while) de $numero es: ".MultiploWhile($numero)."</p>";
            echo "<p>EL múltiplo (do-while) de $numero es: ".MultiploDoWhile($numero)."</p>";
        }
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos indices van de 97 a 122 y cuyos valores son las letras correspondientes del alfabeto.</p>
    <?php
        $arregloLetras = arregloLetras();
        foreach($arregloLetras as $clave => $valor) {
            echo "<p>[$clave] => $valor</p>";
        }
    ?>

    <h2>Ejercicio 5</h2>
    <p>Identificar una persona de sexo femenino y en el rango de edad de 18 a 35 años.</p>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        <label for="edad">Edad: </label><input type="number" name="edad" required><br>
        <label for="sexo">Sexo: </label>
        <select name="sexo" id="sexo" required>
            <option value="">Seleccione</option>
            <option value="Femenino">Femenino</option>
            <option value="Masculino">Masculino</option>
        </select><br>
        <input type="submit" value="Enviar">
    </form>
    <?php
    if(isset($_POST['edad']) && isset($_POST['sexo']))
    {
        $edad = $_POST['edad'];
        $sexo = $_POST['sexo'];
        $mensaje = evaluarPersona($edad, $sexo);
        echo "<p>$mensaje</p>";
    }
    ?>

    <h2>Ejercicio 6</h2>
    <p>Crear en codigo duro un arreglo asociativo que sirva para registrar el parque vehicular de una ciudad.</p>
    
    <h4>Consulta de Parque Vehicular</h4>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" id="matricula" placeholder="Ej. ABC1234">
        <br><br>
        <button type="submit" name="buscar">Buscar</button>
        <button type="submit" name="mostrar_todos">Mostrar Todos</button>
    </form>
    <?php
        if(isset($_POST['buscar']) && isset($_POST['matricula']) && $_POST['matricula'] != ""){
            $matricula = strtoupper(trim($_POST['matricula']));
            if(isset($parqueVehicular[$matricula])){
                mostrarParqueVehicular([$matricula => $parqueVehicular[$matricula]]);
            }
            else{
                echo "<p>No se encontró la matrícula <strong>$matricula</strong> en el parque vehicular.</p>";
            }
        }
        elseif(isset($_POST['mostrar_todos'])){
           mostrarParqueVehicular($parqueVehicular);
        }
    ?>
</body>
</html>