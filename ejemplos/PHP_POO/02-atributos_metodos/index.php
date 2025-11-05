<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>02-Atributos y Métodos</title>
</head>
<body>
    <?php
    require_once __DIR__ . '/Menu.php';

    $menu1 = new Menu();
    $menu1->cargar_opciones("http://facebook.com", "Facebook");
    $menu1->cargar_opciones("http://instagram.com", "Instagram");
    $menu1->cargar_opciones("http://X.com", "X");

    $menu1->graficar();
    ?>
</body>
</html>