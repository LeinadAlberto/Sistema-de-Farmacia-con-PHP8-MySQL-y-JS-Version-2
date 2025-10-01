$(document).ready(function() {

    $('#aviso1').hide();

    $('#aviso').hide();

    $('#form-recuperar').submit( e => {

        let email = $('#email-recuperar').val();

        let dni = $('#dni-recuperar').val();

        if (email == '' || dni == '') {

            Cerrar_Loader('error_credenciales');

            /* $('#aviso').show(); */

            /* $('#aviso').text('Debe llenar todos los campos con sus datos'); */

        } else {

            Mostrar_Loader('Recuperar_password');

            $('#aviso').hide();

            let funcion = 'verificar';

            $.post('../controlador/recuperar.php', { dni, email, funcion }, (response) => {

                if (response == 'encontrado') {

                    let funcion = 'recuperar';

                    $('#aviso').hide();

                    $.post('../controlador/recuperar.php', { funcion, email, dni }, (response2) => {

                        $('#aviso').hide();

                        $('aviso1').hide();

                        /* console.log(response2); */

                        if (response2 == 'enviado') {

                            Cerrar_Loader('');

                            Cerrar_Loader('exito_envio');

                            /* $('#aviso1').show(); */

                            /* $('#aviso1').text('Se restablecio la contraseña con exito, la nueva contraseña fue enviada a su Correo Electrónico'); */

                            $('#form-recuperar').trigger('reset');

                        } else {

                            Cerrar_Loader('');

                            Cerrar_Loader('error_envio');

                            /* $('#aviso').show(); */

                            /* $('#aviso').text('No se pudo reestablecer la contraseña'); */

                            $('#form-recuperar').trigger('reset');

                        }

                    });

                } else {

                    Cerrar_Loader('');

                    Cerrar_Loader('error_usuario');

                    $('#aviso').hide();

                    $('aviso1').hide();

                    /* $('#aviso').show(); */

                    /* $('#aviso').text('El Correo Electrónico y DNI no se encuentran asociados o no estan registrados en el sistema'); */
                }

            });

        }

        e.preventDefault();
        
    });

    function Mostrar_Loader(Mensaje) {

        var texto = null;

        var mostrar = false;

        switch (Mensaje) {

            case 'Recuperar_password':

                texto = 'Por favor, espere un momento mientras procesamos su solicitud...';

                mostrar = true;

                break;
          
        }

        if (mostrar) {

            Swal.fire({

                title: 'Generando nuevo password',

                text: texto,

                showConfirmButton: false

            });

        }

    }

    function Cerrar_Loader(Mensaje) {

        var tipo = null;

        var texto = null;

        var mostrar = false;

        switch (Mensaje) {

            case 'exito_envio':
                
                tipo = 'success';

                texto = 'Verificación exitosa. Se ha enviado una nueva contraseña a su correo electrónico';

                mostrar = true;

            break;

            case 'error_envio':
            
                tipo = 'error';

                texto = 'Verificación exitosa, pero error al generar contraseña nueva. Intente más tarde';

                mostrar = true;

            break;

            case 'error_usuario':
            
                tipo = 'error';

                texto = 'DNI o correo electrónico incorrecto o no asociado. Por favor, verifique sus datos e intente nuevamente.';

                mostrar = true;

            break;

            case 'error_credenciales':
            
                tipo = 'error';

                texto = 'Por favor, complete los campos de DNI y Correo Electrónico';

                mostrar = true;

            break;

            default:

                swal.close();

            break;
          
        }

        if (mostrar) {

            Swal.fire({

                position: 'center',

                icon: tipo,

                text: texto,

                timer: 7000,

                showConfirmButton: true

            });

        }

    }

});