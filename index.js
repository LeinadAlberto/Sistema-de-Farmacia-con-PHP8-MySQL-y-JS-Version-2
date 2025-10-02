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

        if (data.ok) {
                let response = await data.text();

                try {
                    let respuesta = JSON.parse(response);
                    console.log(respuesta);
                } catch (error) {
                    /* console.error(error);
                    console.log(response); */
                    Swal.fire({
                        icon: 'error',
                        title: 'Error', 
                        text: 'Hubo conflicto en el sistema, póngase en contacto con el administrador'
                    })
                }
        } else {
            /* console.error(data.status);
            console.error(data.statusText); */
            Swal.fire({
                icon: 'error',
                title: data.statusText, 
                text: 'Hubo conflicto de código: ' + data.status
            })
        }

    }

})