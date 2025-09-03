<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida
        
        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';
    ?>

    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b y $c:</p>
    <?php
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a;

    echo "<h4>Mostrando el contenido de las variables:</h4>";
    echo "<ul>";
    echo "<li>El valor de \$a es: $a</li>";
    echo "<li>El valor de \$b es: $b</li>";
    echo "<li>El valor de \$c es: $c</li>";
    echo "</ul>";

    $a = "PHP server";
    $b = &$a;

    echo "<h4>Mostrando el contenido de las variables:</h4>";
    echo "<ul>";
    echo "<li>El valor de \$a es: $a</li>";
    echo "<li>El valor de \$b es: $b</li>";
    echo "<li>El valor de \$c es: $c</li>";
    echo "</ul>";

    echo "<h4>Descripción del ejercicio:</h4>";
    echo "<p>En la segunda parte del ejercicio 2 se muestra como el contenido de la variable \$a se cambia a 'PHP server'.<br> Luego \$b se actualiza para referenciar a la variable \$a, entonces ahora \$b tambien tiene el valor 'PHP server'.</p>";
    ?>

    <h2>Ejercicio 3</h2>
    <p>Mostrando el contenido de cada variable inmediatemente despues de cada asignación:</p>
    <?php
        echo "<ul>";
        $a = "PHP5";
        echo "<li>Contenido de \$a es: $a</li>";
        $z[] = &$a;
        echo "<li>Contenido de \$z es: " .print_r($z, true). "</li>";
        $b = "5a version de PHP";
        echo "<li>Contenido de \$b es: </li>";
        var_dump($b);
        $c = (int)$b*10;
        echo "<li>Contenido de \$c es: </li>";
        var_dump($c);
        $a .= $b;
        echo "<li>Contenido de \$a es: </li>";
        var_dump($a);
        $b *= $c;
        echo "<li>Contenido de \$b es: </li>";
        var_dump($b);
        $z[0] = "MySQL";
        echo "<li>Contenido de \$z es: " .print_r($z, true). "</li>";
    ?>

    
</body>
</html>