<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización de Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <?php
            //Recibir datos del formulario
            if(
                isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['marca']) && isset($_POST['modelo']) &&
                isset($_POST['precio']) && isset($_POST['detalles']) && isset($_POST['unidades']) && isset($_POST['imagen'])
            ){
                $id = $_POST['id'];
                $nombre = $_POST['nombre'];
                $marca = $_POST['marca'];
                $modelo = $_POST['modelo'];
                $precio = $_POST['precio'];
                $detalles = $_POST['detalles'];
                $unidades = $_POST['unidades'];
                $imagen = $_POST['imagen'];

                // Conexión a la base de datos
                @$link = new mysqli('localhost', 'root', '05-Miphp530', 'marketzone');

                if ($link->connect_errno) {
                    die('Falló la conexión: ' . $link->connect_error . '<br/>');
                }

                $sql = "UPDATE productos SET nombre = ?, marca = ?, modelo = ?, precio = ?, detalles = ?, unidades = ?, imagen = ? WHERE id = ?";
                
                if($stmt = $link->prepare($sql)) {
                    $stmt->bind_param("sssdisisi", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen, $id);
                    if($stmt->execute()) {
                        echo "<div class='alert alert-success' role='alert'>Producto actualizado exitosamente.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error al actualizar el producto: " . htmlspecialchars($stmt->error) . "</div>";
                    }

                    // Cerrar la declaracion
                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Error al preparar la consulta: " . htmlspecialchars($link->error) . "</div>";
                }
                //cerrar la conexión
                $link->close();
            } else {
                echo "<div class='alert alert-warning' role='alert'>Faltan datos del formulario. Por favor, complete todos los campos.</div>";
          }
        ?>
        <div class="mt-4">
            <a href="get_productos_vigentes_v2.php" class="btn btn-primary">Ver Productos Vigentes</a>
            <a href="get_productos_XHTML_v2.php" class="btn btn-secondary">Ver Productos por Tope</a>
        </div>
    </div>
</body>