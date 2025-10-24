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

    // SE LISTAN TODOS LOS PRODUCTOS
    listarProductos();
}

//INICIO DE CODIGO CON JQUERY
$(document).ready(function() {
    init();

    fetchProducts();

    $("#searchForm").keyup(function() {
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
                        descripcion += '<li>Precio: ' + producto.precio + '</li>';
                        descripcion += '<li>Unidades: ' + producto.unidades + '</li>';
                        descripcion += '<li>Modelo: ' + producto.modelo + '</li>';
                        descripcion += '<li>Marca: ' + producto.marca + '</li>';
                        descripcion += '<li>Detalles: ' + producto.detalles + '</li>';

                        template += `
                            <tr productId="${producto.id}">
                                <td>${producto.id}</td>
                                <td>${producto.nombre}</td>
                                <td><ul>${descripcion}</ul></td>
                                <td>
                                    <buttun class="product-delete btn btn-danger">
                                        Eliminar
                                    </buttun>
                                </td>
                            </tr>
                        `;                
                    });

                    $('#product-results').removeClass('d-none').addClass('d-block');
                    $('#container').html(template_bar);
                    $('#product').html(template);
                }
            });
        } else {
            $('#product-results').removeClass('d-block').addClass('d-none');
            fetchProducts();
        }
    });

    $('#product-form').submit(function(e) {
        e.preventDefault();

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
        finalJSON['nombre'] = nombreProducto;

        let errores = [];
        if (!nombreProducto || nombreProducto.trim() === "" || nombreProducto.length > 100) {
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

        productoJsonString = JSON.stringify(finalJSON, null, 2);

        $.ajax({
            url: './backend/product-add.php',
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

                $('#response-status').removeClass('d-none').addClass('d-block');
                $('#container-status').html(template_bar);

                fetchProducts();

                //Se limpia el frormulario
                $('#product-form').trigger('reset');
                init();
            }
        });
    });


});