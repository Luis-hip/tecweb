<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//ES" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
    <?php
    /** SE CREA EL OBJETO DE CONEXION */
    @$link = new mysqli('localhost', 'root', '05-Miphp530', 'marketzone');
    
    /** comprobar la conexión */
    if ($link->connect_errno) {
        die('Falló la conexión: ' . $link->connect_error . '<br/>');
    }

    /** Crear una consulta que selecciona productos no eliminados */
    $sql = "SELECT * FROM productos WHERE eliminado = 0";
    $result = $link->query($sql);

    $rows = $result->fetch_all(MYSQLI_ASSOC);

    $result->free();
    $link->close();
    ?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Productos Vigentes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css" />
</head>
<body>
    <div class="container-large">
        <h1>Productos Vigentes</h1>
        <?php if (isset($rows) && count($rows) > 0) : ?>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Precio</th>
                        <th>Detalles</th>
                        <th>Unidades</th>
                        <th>Imagen</th>
                        <th>Modificar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['marca']; ?></td>
                            <td><?php echo $row['modelo']; ?></td>
                            <td><?php echo $row['precio']; ?></td>
                            <td><?php echo $row['detalles']; ?></td>
                            <td><?php echo $row['unidades']; ?></td>
                            <td><img src="<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>" width="100"></td>
                            <?php $queryParams = http_build_query($row); ?>
                            <td class="text-center"><a href="formulario_productos_v2.php?<?php echo $queryParams; ?>" class="btn btn-primary"><img src="img/editar.png" alt="editar" width="35px" height="35px"></a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No hay productos vigentes.</p>
        <?php endif; ?>
    </div>
</body>
</html>