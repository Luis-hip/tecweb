//variable para saber si se está editando
let edit = false;

//Resetear estatus de validacion asincrona
let asyncValidacionEstatus = {
    isNameOk: true
};


function init() {
   //Se limpia el formulario
   $('#product-form').trigger('reset');

    //Cambiamos el texto del boton
   $('button.btn-primary').text('Agregar Producto');

    //Limpiamos los mensajes de validacion
   $('small[id$="-validacion"]').text('').removeClass('text-danger text-success');

   //reseteamos el modo edicion
   edit = false;
   $('#productId').val('');
   asyncValidacionEstatus.isNameOk = true;  //reseteamos la validacion de nombre
}

//FUNCIONES DE VALIDACION DEL FORMULARIO
function setValidacionMensaje(campoId, mensaje, esError) {
    const el = $(`#${campoId}-validacion`);
    el.text(mensaje);
    if (!esError) {
        el.removeClass('text-danger').addClass('text-success');
    } else {
        el.removeClass('text-success').addClass('text-danger');
    }
}

function validacionNombre() {
    let nombre = $('#name').val();
    if(nombre === '') {
        setValidacionMensaje('name', 'El nombre no puede estar vacío.', true);
        return false;
    }
    if(nombre.length > 100) {
        setValidacionMensaje('name', 'El nombre no puede exceder los 100 caracteres.', true);
        return false;
    }

    setValidacionMensaje('name', '', false);
    return true;
}

function validacionMarca() {
    let marca = $('#marca').val();
    if(marca === '') {
        setValidacionMensaje('marca', 'Debe seleccionar una marca.', true);
        return false;
    }
    if(marca.length > 25) {
        setValidacionMensaje('marca', 'La marca no puede exceder los 25 caracteres.', true);
        return false;
    }
    setValidacionMensaje('marca', 'Marca válida.', false);
    return true;
}

function validacionModelo() {
    let modelo = $('#modelo').val();
    if(modelo === '') {
        setValidacionMensaje('modelo', 'El modelo no puede estar vacío.', true);
        return false;
    }
    if(modelo.length > 25) {
        setValidacionMensaje('modelo', 'El modelo no puede exceder los 25 caracteres.', true);
        return false;
    }
    setValidacionMensaje('modelo', 'Modelo válido.', false);
    return true;
}

function validacionPrecio() {
    let precio = parseFloat($('#precio').val());
    if(isNaN(precio)) {
        setValidacionMensaje('precio', 'El precio debe ser un número válido.', true);
        return false;
    }
    if(precio < 99.9) {
        setValidacionMensaje('precio', 'El precio debe ser mayor a 99.9.', true);
        return false;
    }
    setValidacionMensaje('precio', 'Precio válido.', false);
    return true;
}

function validacionUnidades() {
    let unidadesVal = $('#unidades').val(); // Obtener el valor como cadena

    if(unidadesVal === '') {
        setValidacionMensaje('unidades', 'Las unidades no pueden estar vacías.', true);
        return false;
    }

    let unidadesNum = parseInt(unidadesVal); // Convertir a entero

    if(isNaN(unidadesNum) ){
        setValidacionMensaje('unidades', 'Las unidades deben ser un número válido.', true);
        return false;
    }

    if(unidadesNum < 0) {
        setValidacionMensaje('unidades', 'Las unidades no pueden ser menores a 0.', true);
        return false;
    }

    setValidacionMensaje('unidades', 'Unidades válidas.', false);
    return true;
}

function validacionDescripcion() {
    let descripcion = $('#descripcion').val();

    if(descripcion.length > 255) {
        setValidacionMensaje('descripcion', 'La descripción no puede exceder los 255 caracteres.', true);
        return false;
    }
    setValidacionMensaje('descripcion', '', false);
    return true;
}
//FIN DE LAS VALIDACIONES

//INICIO DE CODIGO CON JQUERY
$(document).ready(function() {

    init(); //Lamamos la funcion de inicializacion
    fetchProducts();

    //EVENTOS DE VALIDACION
    $('#name').on('blur', validacionNombre);
    $('#marca').on('blur', validacionMarca);
    $('#modelo').on('blur', validacionModelo);
    $('#precio').on('blur', validacionPrecio);
    $('#unidades').on('blur', validacionUnidades);
    $('#descripcion').on('blur', validacionDescripcion);

    //VALIDACION ASINCRONA DEL NOMBRE
    $('#name').on('keyup', function() {
        let nombre = $('#name').val();
        let id = $('#productId').val();

        if(!validacionNombre()) {
            asyncValidacionEstatus.isNameOk = false;
            return; //Si la validacion basica falla, no hacemos la llamada AJAX
        }

        if(nombre.trim() !== '') {
            $.ajax({
                url: './backend/product-check-name.php',
                type: 'GET',
                data: { name: nombre, id: id }, //Enviamos el nombre y el id
                success: function(response) {
                    let resultado = JSON.parse(response);
                    if(resultado.exists) {
                        setValidacionMensaje('name', 'El nombre ya existe. Por favor elige otro.', true);
                        asyncValidacionEstatus.isNameOk = false;
                    }else {
                        setValidacionMensaje('name', 'Nombre disponible.', false);
                        asyncValidacionEstatus.isNameOk = true;
                    }
                }
            });
        }
    });

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

        //Validacion general antes de enviar
        let v1 = validacionNombre();
        let v2 = validacionMarca();
        let v3 = validacionModelo();
        let v4 = validacionPrecio();
        let v5 = validacionUnidades();
        let v6 = validacionDescripcion();

        //Validacion asincrona de nombre
        if(!asyncValidacionEstatus.isNameOk) {
            v1 = false; //Si la validacion asincrona falla, marcamos v1 como false
        }

        if(!(v1 ||  v2 || v3 || v4 || v5 || v6)) {
            alert('Por favor corrija los errores en el formulario antes de enviarlo.');
            return;
        }

        let finalJSON = {
            nombre: $('#name').val(),
            precio: parseFloat($('#precio').val()),
            unidades: parseInt($('#unidades').val()),
            modelo: $('#modelo').val(),
            marca: $('#marca').val(),
            detalles: $('#descripcion').val(),
            Image: $('#imagen').val() || 'img/default.png' // Valor por defecto si no se proporciona una URL
        };

        //Se agrega el id al JSON si se estamos editando
        if(edit === true){
            finalJSON['id'] = $('#productId').val();
        }

        let productoJsonString = JSON.stringify(finalJSON, null, 2);

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

                //Se limpia el formulario y se reseta el boton
                init(); //Usando la funcion init()
            }
        });
    });

    //EVENTO PARA EDITAR UN PRODUCTO
    $(document).on('click', '.product-edit, .product-item', function(e) {
        e.preventDefault();

        //Limpiamos validaciones anteriores
        $('small[id$="-validacion"]').text('').removeClass('text-danger text-success');
        asyncValidacionEstatus.isNameOk = true; //reseteamos la validacion de nombre

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
                $('#precio').val(parseFloat(producto.precio));
                $('#unidades').val(parseInt(producto.unidades));
                $('#modelo').val(producto.modelo);
                $('#marca').val(producto.marca);
                $('#descripcion').val(producto.detalles);
                $('#imagen').val(producto.imagen);

                //Modificamos el texto del boton
                $('button.btn-primary').text('Editar Producto');

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
