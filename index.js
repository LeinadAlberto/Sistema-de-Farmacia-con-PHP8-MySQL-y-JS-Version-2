$(document).ready(function() {

    $('#form-login').submit( (e) => {

        let dni = $('#dni').val();
        let pass = $('#pass').val();

        login(dni, pass);

        e.preventDefault();
    })

    async function login(dni, pass) {

        let funcion = 'login';

        let data = await fetch('/farmaciav2/Controllers/UsuarioController.php', {
            method: 'POST', 
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}, 
            body: 'funcion='+funcion+'&&dni='+dni+'&&pass='+pass
        })

        let response = await data.text();

        console.log(response);
    }

})