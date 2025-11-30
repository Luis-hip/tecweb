$(document).ready(function() {
    //Proceso de inicio de sesion
    $('#login-form').submit(function(e) {

        e.preventDefault(); //Evita el envio normal del formulario
        console.log('Click detectado');
        //Obtener datos del formulario de login
        const data = {
            email: $('#login-email').val(), 
            password: $('#login-pass').val()
        };

        //Envia peticion AJAX para iniciar sesion
        $.ajax({
            url: './backend/auth-login.php', //Archivo que valida el login
            type: 'POST',                    //Metodo de envio
            data: JSON.stringify(data),      //Convertir datos a JSON
            contentType: 'application/json', //Indicar que se envia JSON

            //Se ejecuta cuando el servidor responde
            success: function(res) {
                //Convertir respuesta a objeto si viene como string
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                //login exitoso
                if(r.status === 'success') {
                    //Guarda el email en el almacenamiento local
                    localStorage.setItem('user_email', r.email);
                    $('#auth-message').html('<div class="alert alert-success">Entrando...</div>');
                    //Redirigir segun el rol del usuario
                    setTimeout(() => window.location.href = r.role === 'admin' ? 'dashboard.html' : 'index.html', 1500);
                }else { //login fallido
                    $('#auth-message').html(`<div class="alert alert-danger"> ${r.message} </div>`);
                }
            }
        });
    });

    //Proceso de registro
    $('#singup-form').submit(function(e) {
        e.preventDefault();
        const data = {email: $('#singup-email').val(), password: $('#singup-pass').val(), name: $('#singup-name').val()};
        $.ajax({
            url: './backend/auth-singup.php', //Archivo que valida el registro
            type: 'POST',                     //Metodo de envio 
            data: JSON.stringify(data),       //Convertir datos a JSON
            contentType: 'application/json',  //Indicar que se envia JSON

            success: function(res) { //Manejo de la respuesta del servidor
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                if(r.status === 'success') {
                    $('#auth-message').html('<div class="alert alert-success">Registro exitoso</div>');
                    $('#singup-form').trigger('reset'); //Limpiar formulario
                }else{
                    $('#auth-message').html(`<div class="alert alert-danger"> ${r.message} </div>`);
                }
            }
        });
    });
});