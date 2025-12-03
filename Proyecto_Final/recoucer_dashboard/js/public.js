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
                            <h5>${i.nombre}</h5>
                            <h6>${i.lenguaje} | ${i.formato}</h6>
                            <p>${i.descripcion}</p>
                        </div>
                        <div class="card-footer">
                            <a href="${i.url}" target="_blank" class="btn btn-primary btn-block">Ver</a>
                        </div>
                    </div>
                </div>`;
        });
        // Mostrar el contenido generado en el contenedor publico o mensaje si no hay disponibles
        $('#public-resources-container').html(tpl || '<p class="text-center w-100">No hay recursos disponibles.</p>');
    }

    // Cargar recursos al iniciar
    $.get('./backend/resource-list.php', render); 

    // Buscar recursos al escribir en el campo de busqueda
    $('#public-search').keyup(function() {
        // Si el input tiene texto, usa la ruta de busqueda; si esta vacio, cargar todos los recursos
        $.get($(this).val() ? './backend/resource-search.php' : './backend/resource-list.php', {search: $(this).val()}, render);
    });

    //
    //Verificar la sesion del usuario
    const userEmail = localStorage.getItem('user_email');
    const userRole = localStorage.getItem('user_role');
    
    if(userEmail) {
        //Variable para guardar el boton admin (por defecto vacio)
        let adminButton = '';

        //Si el rol es admin, agregamos el boton de dashboard
        if (userRole === 'admin') {
            adminButton = '<a class="dropdown-item font-weight-bold text-primary" href="dashboard.html">Ir al Dashboard</a><div class="dropdown-divider"></div>';
        }
        
        //si existe el email, buscamos el enlace de iniciar sesion y lo reemplazamos por el menu de usuario
        // Insertamos el menú con la variable adminButton incluida
        $('#nav-auth').html(`
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ${userEmail}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    ${adminButton}
                    
                    <a class="dropdown-item" href="#" id="logoutBtn">Cerrar sesión</a>
                </div>
            </li>
        `);

        //Cerrar sesión
        $('#logoutBtn').click(function(e) {
            e.preventDefault();
            $.get('./backend/auth-logout.php', function() {
                // Borramos email Y ROL
                localStorage.removeItem('user_email');
                localStorage.removeItem('user_role');
                window.location.reload();
            });
        });
    }
});