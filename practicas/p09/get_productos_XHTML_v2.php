<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<?php
	if(isset($_GET['tope']))
		$tope = $_GET['tope'];

	if (!empty($tope))
	{
		/** SE CREA EL OBJETO DE CONEXION */
		@$link = new mysqli('localhost', 'root', '05-Miphp530', 'marketzone');	

		/** comprobar la conexión */
		if ($link->connect_errno) 
		{
			die('Falló la conexión: '.$link->connect_error.'<br/>');
			/** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
		}

		/** Crear una consulta que selecciona productos con unidades menores o iguales al tope */
		if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= '{$tope}'") ) 
		{
			$rows = $result->fetch_all(MYSQLI_ASSOC);
			/** útil para liberar memoria asociada a un resultado con demasiada información */
			$result->free();
		}

		$link->close();
	}
	?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Productos con Unidades hasta Tope</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="styles.css" />
	</head>
	<body>
		<h3>PRODUCTOS</h3>

		<br/>
		
		<?php if( isset($rows) && count($rows) > 0 ) : ?>

			<table class="table">
				<thead class="thead-dark">
					<tr>
						<th scope="col">#</th>
						<th scope="col">Nombre</th>
						<th scope="col">Marca</th>
						<th scope="col">Modelo</th>
						<th scope="col">Precio</th>
						<th scope="col">Unidades</th>
						<th scope="col">Detalles</th>
						<th scope="col">Imagen</th>
						<th scope="col">Modificar</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach( $rows as $row ) : ?>
						<tr>
                            <th scope="row"><?= $row['id'] ?></th>
                            <td><?= $row['nombre'] ?></td>
                            <td><?= $row['marca'] ?></td>
                            <td><?= $row['modelo'] ?></td>
                            <td><?= $row['precio'] ?></td>
                            <td><?= $row['unidades'] ?></td>
                            <td><?= utf8_encode($row['detalles']) ?></td>
                            <td><img src=<?= $row['imagen'] ?> alt="Imagen de producto" width="100" /></td>
							<?php $queryParams = http_build_query($row); ?>
							<td><a href="formulario_productos_v2.php?<?php echo $queryParams; ?>" class="btn btn-primary"><img src="img/editar.png" alt="editar" width="35px" height="35px"></a></td>
					    </tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		<?php elseif(!empty($tope)) : ?>

			 <script>
                alert('No se encontraron productos con unidades menores o iguales a <?= htmlspecialchars($tope) ?>');
             </script>

		<?php endif; ?>
	</body>
</html>