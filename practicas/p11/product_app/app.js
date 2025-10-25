// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
  };

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
}

//INICIO DE CODIGO CON JQUERY
$(document).ready(function() {
    //Variablea para sabaer si se está editando
    let edit = false;

    init();
    fetchProducts();

    $("#search").keyup(function() {
        if($("#search").val()) {
            let search = $("#search").val();
            $.ajax({
                url: './backend/product-search.php?search=' + search,
                type: 'GET',
                success: function(response) {
                    let productos = JSON.parse(response);
                    let template = '';
                    let template_bar = '';

                    productos.forEach(producto => {
                        let descripcion = '';
                        descripcion += '<li>Precio: '+producto.precio+'</li>';
                        descripcion += '<li>Unidades: '+producto.unidades+'</li>';
                        descripcion += '<li>Modelo: '+producto.modelo+'</li>';
                        descripcion += '<li>Marca: '+producto.marca+'</li>';
                        descripcion += '<li>Detalles: '+producto.detalles+'</li>';

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>
                                    <a href="#" class="product-item">${producto.nombre}</a>
                                </td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <button class="product-delete btn btn-danger">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `; 
                        template_bar += `<li>${producto.nombre}</li>`;
                    });

                    $('#product-results').removeClass('d-none').addClass('d-block');
                    $('#container').html(template_bar);
                    $('#products').html(template);
                }
            });
        } else {
            //Si la busqueda está vacía, se muestran todos los productos
            $('#product-results').removeClass('d-block').addClass('d-none');
            fetchProducts();
        }
    });

    $('#product-form').submit(function(e) {
        e.preventDefault();

        //Se obtienen los valores
        var productoJsonString = $('#description').val();
        var nombre = $('#name').val();
        var finalJSON;

        //VALIDACIONES
        if(productoJsonString.trim() === '') {
            alert('El campo de descripción no puede estar vacío.');
            return;
        }
        try {
            finalJSON = JSON.parse(productoJsonString);
        } catch (error) {
            alert('El campo de descripción debe ser un JSON válido.');
            return;
        }

        // Se agrega el nombre al JSON
        finalJSON['nombre'] = nombre;

        let errores = [];
        if (!nombre || nombre.trim() === "" || nombre.length > 100) {
            errores.push('El nombre del producto no debe estar vacío y debe tener menos de 100 caracteres.');
        }
        if(finalJSON.precio <= 99.9 || isNaN(finalJSON.precio)) {
            errores.push('El precio debe ser un número mayor a 99.9');
        }
        if(finalJSON.unidades < 0 || isNaN(finalJSON.unidades)) {
            errores.push('Las unidades deben ser un número mayor o igual a 0');
        }
        if(!finalJSON.modelo || finalJSON.modelo === "NA" || finalJSON.modelo.length > 25) {
            errores.push('El modelo no debe estar vacío y debe tener menos de 25 caracteres.');
        }
        if(!finalJSON.marca || finalJSON.marca === "NA" || finalJSON.marca.length > 25) {
            errores.push('La marca no debe estar vacía y debe tener menos de 25 caracteres.');
        }
        if(finalJSON.detalles && finalJSON.detalles.length > 255) {
            errores.push('Los detalles deben tener 255 caracteres o menos.');
        }
        if(errores.length > 0) {
            alert(errores.join('\n'));
            return;
        }

        //Se agrega el id al JSON si se estamos editando
        if(edit === true){
            finalJSON['id'] = $('#productId').val();
        }

        productoJsonString = JSON.stringify(finalJSON, null, 2);

        //Definimos a que url estamos envindo (agregar o editar)
        let url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';

        $.ajax({
            url: url,
            type: 'POST',
            data: productoJsonString,
            contentType: 'application/json; charset=utf-8',
            success: function(response) {
                let respuesta = JSON.parse(response);

                let template_bar = "";
                template_bar += `
                    <li style="list-style: nome;">status: ${respuesta.status}</li>
                    <li style="list-style: nome;">message: ${respuesta.message}</li>
                `;

                $('#product-result').removeClass('d-none').addClass('d-block');
                $('#container').html(template_bar);

                //Cargar la lista de productos actualizada
                fetchProducts();

                //SE LIMMPIA EL FORMULARIO
                $('#product-form').trigger('reset');
                init();

                //Reseteamos el modo edicion
                edit = false;
                $('#productId').val('');
            }
        });
    });

    //EVENTO PARA EDITAR UN PRODUCTO
    $(document).on('click', '.product-edit, .product-item', function(e) {
        e.preventDefault();

        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');

        $.ajax({
            url: './backend/product-single.php?id=' + id,
            type: 'GET',
            success: function(response) {
                let producto = JSON.parse(response);

                //LLENAR EL FORMULARIO CON LOS DATOS DEL PRODUCTO
                $('#name').val(producto.nombre);
                $('#productId').val(producto.id);

                //Creamos el JSON solo con los datos para el textarea
                let descripcionJSON = {
                    "precio": parseFloat(producto.precio),
                    "unidades": parseInt(producto.unidades),
                    "modelo": producto.modelo,
                    "marca": producto.marca,
                    "detalles": producto.detalles,
                };

                $('#description').val(JSON.stringify(descripcionJSON, null, 2));

                //Activamos el modo edicion
                edit = true;
            }
        });
    });

    //EVENTO PARA ELIMINAR UN PRODUCTO
    $(document).on('click', '.product-delete', function() {
        if(confirm('¿Estás seguro de que deseas eliminar este producto?')) {
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId');

            $.ajax({
                url: './backend/product-delete.php?id=' + id,
                type: 'DELETE',
                success: function(response) {
                    let respuesta = JSON.parse(response);

                    //MOSTRAR MENSAJE DE ESTATSUS
                    let template_bar = "";
                    template_bar += `
                        <li style="list-style: none;">status: ${respuesta.status}</li>
                        <li style="list-style: none;">message: ${respuesta.message}</li>
                    `;
                    $('#product-result').removeClass('d-none').addClass('d-block');
                    $('#container').html(template_bar);

                    //Cargar| la lista de productos actualizada
                    fetchProducts();
                }
            });
        }
    });

    //FUNCION PARA CARGAR TODOS LOS PRODUCTOS
    function fetchProducts() {
        $.ajax({
            url: './backend/product-list.php',
            type: 'GET',
            success: function(response) {
                let productos = JSON.parse(response);
                let template = '';
                productos.forEach(producto => {
                    let descripcion = '';
                    descripcion += '<li>Precio: '+producto.precio+'</li>';
                    descripcion += '<li>Unidades: '+producto.unidades+'</li>';
                    descripcion += '<li>Modelo: '+producto.modelo+'</li>';
                    descripcion += '<li>Marca: '+producto.marca+'</li>';
                    descripcion += '<li>Detalles: '+producto.detalles+'</li>';

                    template += `
                        <tr productId="${producto.id}">
                            <td>${producto.id}</td>
                            <td>
                                <a href="#" class="product-item">${producto.nombre}</a>
                            </td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;                
                });

                $('#products').html(template);
            }
        });
    }        
});
