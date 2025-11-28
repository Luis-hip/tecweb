$(document).ready(function() {
    //Funcion para renderizar recursos
    function render(res){
        let tpl = '';
        const data = typeof res === 'string' ? JSON.parse(res) : res;
        //Recorrer cada recurso recibido desde el backend
        data.forEach(i => {
            tpl += `
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5>${i.name}</h5>
                            <h6>${i.language} | ${i.format}</h6>
                            <p>${i.description}</p>
                        </div>
                        <div class="card-footer">
                            <a href="${i.url}" target="_blank" class="btn btn-primary btn-block">Ver</a>
                        </div>
                    </div>
                </div>`;
        });
        // Mostrar el contenido generado en el contenedor publico o mensaje si no hay disponibles
        $('#public_resources-container').html(tpl || '<p class="text-center w-100">No hay recursos disponibles.</p>');
    }

    // Cargar recursos al iniciar
    $.get('./backend/resource-list.php', render); 

    // Buscar recursos al escribir en el campo de busqueda
    $('#public-search').keyup(function() {
        // Si el input tiene texto, usa la ruta de busqueda; si esta vacio, cargar todos los recursos
        $.get($(this).val() ? './backend/resource-search.php' : './backend/resource-list.php', {search: $(this).val()}, render);
    });
});