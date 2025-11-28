$(document).ready(function() {
    //Cargar Graficas
    $.get('./backend/starts-get.php', function(res) {
        const data = typeof res === 'string' ? JSON.parse(res) : res;
        if(data.by_format){
            // Grafica de formatos de archivo
            new Chart(document.getElementById('chartFormat'), {
                type: 'doughnut',
                data:  {labels: data.by_format.map(x=>x.label), datasets: [{data: data.by_format.map(x=>x.count), backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'] }] },
                options: {title: {display: true, text: 'Formartos'}}
            });
            // Grafica de lenguajes de programacion
            new Chart(document.getElementById('chartLang'), {
                type: 'pie',
                data: {labels: data.by_language.map(x=>x.label), datasets: [{data: data.by_language.map(x=>x.count), backgroundColor: ['#4BC0C0', '#9966FF', '#FF9F40'] }] }
            });
            // Grafica de actividad de usuarios
            new Chart(document.getElementById('chartActivity'), {
                type: 'bar',
                data: {labels: data.by_activity.map(x=>x.label), datasets: [{label: 'Accesos', data: data.by_activity.map(x=>x.count), backgroundColor: '#36A2EB' }] }
            });
        }
    });

    //Obtener y mostrar la lista de recursos en la tabla
    function fetchResources() {
        $.get('./backend/resource-list.php', function(res) {
            let tpl = '';
            const data = typeof res === 'string' ? JSON.parse(res) : res;
            data.forEach(i => {
                tpl += `<tr resourceId = "${i.id}">
                    <td>${i.id}</td>
                    <td>${i.name}</td>
                    <td>${i.language}</td>
                    <td>
                        <button class="btn btn-sm btn-warning resource-edit">Editar</button>
                        <button class="btn btn-sm btn-danger resource-delete">Eliminar</button>
                    </td>
                </tr>`;
            });
            $('#resources-table').html(tpl);
        });
    }

    // Cargar recursos al iniciar
    fetchResources();

    // Enviar formulario de recurso (agregar/editar)
    $('#resource-form').submit(function(e) {
        e.preventDefault();
        const d ={
            name: $('#name').val(), 
            description: $('#description').val(), 
            url: $('#url').val(),
            format: $('#format').val(), 
            language: $('#language').val(), 
            id: $('#resourceId').val()
        };

        // Determinar si es agregar o editar
        $.post(d.id ? './backend/resource-edit.php' : './backend/resource-add.php', JSON.stringify(d), function(res) {
            fetchResources();   //Recargar la lista
            $('#resource-form').trigger('reset');   //Limpia el formulario
            $('#resourceId').val('');   //Limpia el campo oculto
        });
    });

    // Eliminar recurso
    $(document).on('click', '.resource-delete', function() {
        if(confirm('¿Estás seguro de eliminar este recurso?')){
            $.get('./backend/resource-delete.php', {id: $(this).closest('tr').attr('resourceId')}, fetchResources);
        }
    });

    // Editar recurso - cargar datos en el formulario
    $(document).on('click', '.resource-edit', function() {
        $.get('./backend/resource-single.php', {id: $(this).closest('tr').attr('resourceId')}, function(res) {
            const d = typeof res === 'string' ? JSON.parse(res) : res;
            $('#name').val(d.name); $('#description').val(d.description); $('#url').val(d.url);
            $('#format').val(d.format); $('#language').val(d.language); $('#resourceId').val(d.id);
        });
    });

    //Cerrar sesión
    $('#logoutBtn').click(function() {
        $.get('./backend/auth-logout.php', function() {
            window.location.href = 'index.html';
        });
    });
});