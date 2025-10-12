<?php
	//verificicamos si estamos editando un producto
	$modo_edicion = isset($_GET['id']);

	$id = htmlspecialchars($_GET['id'] ?? '');
	$nombre = htmlspecialchars($_GET['nombre'] ?? '');
	$marca = htmlspecialchars($_GET['marca'] ?? '');
	$modelo = htmlspecialchars($_GET['modelo'] ?? '');
	$precio = htmlspecialchars($_GET['precio'] ?? '');
	$detalles = htmlspecialchars($_GET['detalles'] ?? '');
	$unidades = htmlspecialchars($_GET['unidades'] ?? '');
	$imagen = htmlspecialchars($_GET['imagen'] ?? '');

    if($modo_edicion){
        $title = "Editar Producto";
        $accion = "update_producto.php";
        $TextoBoton = "Actualizar Producto";
    }
    else{
        $title = "Agregar Nuevo Producto";
        $accion = "set_producto_v2.php";
        $TextoBoton = "Agregar Producto";
    }
?>

<!DOCTYPE html>
<html lang="ES">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById("formularioProducto");

            const errorContainer = document.createElement("div");
            errorContainer.className = "error-Container";
            errorContainer.style.display = "none";
            form.after(errorContainer);

            form.addEventListener("submit", function(event) {
                let errors = [];

                event.preventDefault(); // Evitar el envío del formulario por defecto
                const nombre = document.getElementById("nombre").value.trim();
                const marca = document.getElementById("marca").value;   
                const modelo = document.getElementById("modelo").value.trim();
                const precio = parseFloat(document.getElementById("precio").value);
                const detalles = document.getElementById("detalles").value.trim();
                const unidades = parseInt(document.getElementById("unidades").value);
                const imagenInput = document.getElementById("imagen").value.trim();

                // Validaciones 
                if(nombre === "" ){
                    errors.push("El nombre del producto no puede estar vacío.");
                } 
                else if(nombre.length > 100){
                    errors.push("El nombre del producto no puede exceder los 100 caracteres.");
                }

                if(marca === ""){
                    errors.push("Debe seleccionar una marca.");
                }
                
                if(modelo === ""){
                    errors.push("El modelo del producto no puede estar vacío.");
                } 
                else if(modelo.length > 25){
                    errors.push("El modelo del producto no puede exceder los 25 caracteres.");
                }

                if(isNaN(precio)){
                    errors.push("El precio del producto debe ser un número válido.");
                } 
                else if(precio <= 99.9){
                    errors.push("El precio del prooducto debe ser mayor de 99.9");
                }

                if(detalles.length > 255){
                    errors.push("Los detalles del producto no pueden exceder los 255 caracteres.");
                }

                if(isNaN(unidades)){
                    errors.push("Las unidades del producto deben ser un número válido.");
                }
                else if(unidades === '' || unidades < 0){
                    if(unidades === ''){
                        errors.push("Las unidades del producto no pueden estar vacías.");
                    } else{
                        errors.push("Las unidades del producto no pueden ser menores a 0");
                    }
                }
                //Fin de las validaciones
                if(errors.length > 0){
                    errorContainer.innerHTML = ''; // Limpiar errores previos
                    const errorList = document.createElement("ul");
                    errors.forEach(element => {
                        const lisItem = document.createElement("li");
                        lisItem.textContent = element;
                        errorList.appendChild(lisItem);
                    });
                    errorContainer.appendChild(errorList);
                    errorContainer.style.display = "block"; // Mostrar el contenedor de errores
                } else {
                    errorContainer.style.display = "none"; // Ocultar el contenedor de errores
                    if(imagenInput === ""){ //Asignnamos imagen por defecto si no se proporciona ninguna
                        imagenInput.value = "img/imagen.png";
                        
                        form.submit(); // Enviar el formulario si no hay errores
                    }
                }
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1><?php echo $title; ?></h1>
        <form id="formularioProducto" action="<?php echo $accion; ?>" method="POST">
            <?php if($modo_edicion): ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
            <?php endif; ?>
            <label for="nombre">Nombre del producto:</label>
            <input type="text" id="nombre" name="nombre" maxlength="100" value="<?php echo $nombre?>">
            <br />
            <label for="marca">Marca del producto:</label>
            <select class="selec" name="marca" id="marca">
                <option value="" disabled selected>Seleccione una marca</option>
                <?php 
                    $marcas_disponibles = [
                        "Apple", "Samsung", "Huawei", "Xiaomi", "Oppo", "Motorola", "Google", "Vivo", "Realme", "OnePlus", "Sony", "LG", "Nokia", "HTC", "ZTE", "Alcatel", "TCL"
                    ];
                    foreach($marcas_disponibles as $marca_opcion){
                        $selected = ($marca === $marca_opcion) ? 'selected' : '';
                        echo "<option value=\"$marca_opcion\" $selected>$marca_opcion</option>";
                    }
                ?>
            </select>
            <br />
            <label for="modelo">Modelo del producto:</label>
            <input type="text" id="modelo" name="modelo" maxlength="25" value="<?php echo $modelo?>">
            <br />
            <label for="precio">Precio del producto:</label>
            <input type="number" id="precio" name="precio" step="0.01" value="<?php echo $precio?>">
            <br />
            <label for="detalles">Detalles del producto:</label>
            <textarea id="detalles" name="detalles" placeholder="No más de 255 caracteres de longitud" maxlength="255"><?php echo $detalles?></textarea>
            <br />
            <label for="unidades">Unidades del producto:</label>
            <input type="number" id="unidades" name="unidades" min="0" step="1" value="<?php echo $unidades?>">
            <br />
            <label for="imagen">URL de la imagen del producto:</label>
            <input type="text" id="imagen" name="imagen" maxlength="100" value="<?php echo $imagen?>">
            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</body>
</html>