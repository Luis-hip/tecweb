<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $marca  = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $detalles = $_POST['detalles'];
    $unidades = $_POST['unidades'];
    $imagen = $_POST['imagen'];

    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', '05-Miphp530', 'marketzone');

    /** comprobar la conexión */
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error . '<br/>');
        /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
    }

    $sql_val = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND marca= '{$marca}' AND modelo = '{$modelo}'";
    $result = $link->query($sql_val);

    if($result->num_rows > 0) {
        echo 'El producto ya existe en la base de datos. <br />';
        echo '<a href="http://localhost/tecweb/practicas/p09/formulario_productos_v2.php">Intentar nuevamente</a>';
    } else {
        /** Crear una tabla que nos devuelve un conjunto de resultados */
        /**$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}', 0)";*/
        $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) VALUES ('{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";
        if ($link->query($sql)) {
            echo '<h1>Producto insertado exitosamente</h1>';
            echo '<p>Producto insertado con ID: ' . $link->insert_id . '</p>';
            echo '<h3>Resumen del producto:</h3>';
            echo '<ul>';
            echo '<li>nombre:' . $nombre . '</li>';
            echo '<li>marca:' . $marca . '</li>';
            echo '<li>modelo:' . $modelo . '</li>';
            echo '<li>precio:' . $precio . '</li>';
            echo '<li>detalles:' . $detalles . '</li>';
            echo '<li>unidades:' . $unidades . '</li>';
            echo '<img src="' . $imagen . '" alt="Imagen del producto" width="200" style="max-width: 100%;">';
            echo '</ul>';
           echo '<div class="mt-4">
                    <a href="get_productos_vigentes_v2.php" class="btn btn-primary">Ver Productos Vigentes</a>
                    <a href="get_productos_XHTML_v2.php" class="btn btn-secondary">Ver Productos por Tope</a>
                    <a href="formulario_productos_v2.php" class="btn btn-success">Agregar Otro Producto</a>
                </div>';
        } else {
            echo '<h1>El Producto no pudo ser insertado</h1>';
            echo '<a href="http://localhost/tecweb/practicas/p09/formulario_productos_v2.php">Intentar nuevamente</a>';
        }
    }
    $link->close();   
}
else{
    echo '<h1>ERROR!</h1>';
    echo '<p>Acceso no autorizado</p>';
}
?>