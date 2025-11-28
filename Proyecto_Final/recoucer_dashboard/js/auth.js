$(document).ready(function() {
    $('#login-form').submit(function(e) {
        e.preventDefault();
        const data = {email: $('#login-email').val(), password: $('#login-pass').val()};
        $.ajax({
            url: './backend/auth-login.php', type: 'POST', data: JSON.stringify(data), contentType: 'application/json',
            success: function(res) {
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                if(r.status === 'success') {
                    $('#auth-mesage').html('<div class="alert alert-success">Entrando...</div>');
                    setTimeout(() => window.location.href = r.role === 'admin' ? 'dashboard.html' : 'index.html', 1500);
                }else {
                    $('#auth-mesage').html(`<div class="alert alert-danger"> ${r.message} </div>`);
                }
            }
        });
    });

    $('#singup-form').submit(function(e) {
        e.preventDefault();
        const data = {email: $('#singup-email').val(), password: $('#singup-pass').val(), name: $('#singup-name').val()};
        $.ajax({
            url: './backend/auth-singup.php', type: 'POST', data: JSON.stringify(data), contentType: 'application/json',
            success: function(res) {
                const r = typeof res === 'string' ? JSON.parse(res) : res;
                if(r.status === 'success') {
                    $('#auth-mesage').html('<div class="alert alert-success">Registro exitoso</div>');
                    $('#singup-form').trigger('reset');
                }else{
                    $('#auth-mesage').html(`<div class="alert alert-danger"> ${r.message} </div>`);
                }
            }
        });
    });
});