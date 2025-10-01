$(document).ready(function() {
    var funcion = '';
    var id_usuario = $('#id_usuario').val(); /* id del usuario que esta logueado */
    /* console.log(id_usuario); */
    var edit = false;/* Bandera que controla la acción de editar datos personales */

    buscar_usuario(id_usuario);
    
    function buscar_usuario(dato) {
        funcion = 'buscar_usuario';
        $.post('../controlador/UsuarioController.php', {dato, funcion}, (response) => {
            let nombre = '';
            let apellidos = '';
            let edad = '';
            let dni = '';
            let tipo = '';
            let telefono = '';
            let residencia = '';
            let correo = '';
            let sexo = '';
            let adicional = '';
        
            const usuario = JSON.parse(response);

            nombre += `${usuario.nombre}`;
            apellidos += `${usuario.apellidos}`;
            edad += `${usuario.edad}`;
            dni += `${usuario.dni}`;
            if (usuario.tipo == "Root") {
                tipo += `<h1 class="badge badge-danger">${usuario.tipo}</h1>`;
            }
            if (usuario.tipo == "Administrador") {
                tipo += `<h1 class="badge badge-warning">${usuario.tipo}</h1>`;
            }
            if (usuario.tipo == "Tecnico") {
                tipo += `<h1 class="badge badge-info">${usuario.tipo}</h1>`;
            }
            telefono += `${usuario.telefono}`;
            residencia += `${usuario.residencia}`;
            correo += `${usuario.correo}`;
            sexo += `${usuario.sexo}`;
            adicional += `${usuario.adicional}`;
            
            $('#nombre_us').html(nombre);
            $('#apellidos_us').html(apellidos);
            $('#edad').html(edad);
            $('#dni_us').html(dni);
            $('#us_tipo').html(tipo);

            $('#telefono_us').html(telefono);
            $('#residencia_us').html(residencia);
            $('#correo_us').html(correo);
            $('#sexo_us').html(sexo);
            $('#adicional_us').html(adicional);
            $('#avatar2').attr('src', usuario.avatar); /* Cambia la url del avatar que se muestra en datos personales */
            $('#avatar1').attr('src', usuario.avatar); /* Cambia la url del avatar que se encuentra en el modal de cambiar avatar  */
            $('#avatar3').attr('src', usuario.avatar); /* Cambia la url del avatar que se encuentra en el modal de cambiar contraseña */
            $('#avatar4').attr('src', usuario.avatar); /* Cambia la url del avatar que se encuentra en el sidebar user en nav.php */
        });               
    }

    $(document).on('click', '.edit', (e) => {
        funcion = 'capturar_datos';
        edit = true; // Bandera que al tener valor true permita editar datos personales del usuario logueado
        $.post('../controlador/UsuarioController.php',{funcion, id_usuario}, (response) => {
            /* console.log(response); */
            const usuario = JSON.parse(response);
            /* console.log(usuario); */
            $('#telefono').val(usuario.telefono);
            $('#residencia').val(usuario.residencia);
            $('#correo').val(usuario.correo);
            $('#sexo').val(usuario.sexo);
            $('#adicional').val(usuario.adicional);
        });
    }); 

    $('#form-usuario').submit(e => {
        if (edit == true) {
            let telefono = $('#telefono').val();
            let residencia = $('#residencia').val();
            let correo = $('#correo').val();
            let sexo = $('#sexo').val();
            let adicional = $('#adicional').val();
            funcion = 'editar_usuario';
            $.post('../controlador/UsuarioController.php', {funcion, id_usuario, telefono, residencia, correo, sexo, adicional}, (response) => {
                if (response == 'editado') {
                    $('#editado').hide('slow'); /* Oculta la alerta actual */
                    $('#editado').show(1500); /* Muestra el nuevo alert  */
                    $('#editado').hide(1500); /* Ocultar luego de 2 segundos */
                    $('#form-usuario').trigger('reset'); /* Resetea todos los campos del formulario */
                }
                edit = false;
                buscar_usuario(id_usuario);
            });
            
        } else {
            $('#noeditado').hide('slow');
            $('#noeditado').show(1700);
            $('#noeditado').hide(1700);
            $('#form-usuario').trigger('reset');
        }
        e.preventDefault();
    });

    /* Evento que se encarga de cambiar la contraseña del usuario logueado. */
    $('#form-pass').submit(e => {
        let oldpass = $('#oldpass').val();
        let newpass = $('#newpass').val();
        funcion = 'cambiar_contra';
        $.post('../controlador/UsuarioController.php', {funcion, id_usuario, oldpass, newpass}, (response) => {
            response = response.trim();
            if (response == 'update') {
                $('#update').hide('slow');
                $('#update').show(1500);
                $('#update').hide(1500);
                $('#form-pass').trigger('reset');
            } else {
                $('#noupdate').hide('slow');
                $('#noupdate').show(1500);
                $('#noupdate').hide(1500);
                $('#form-pass').trigger('reset');
            }
        });
        e.preventDefault();
    }); 

    /* Uso de FormData para cambio de avatar. */
    $('#form-photo').submit(e => {
        let formData = new FormData($('#form-photo')[0]);
        $.ajax({
            url: '../controlador/UsuarioController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function(response) {
            const json = JSON.parse(response);
            if (json.alert == 'edit') {
                $('#avatar1').attr('src', json.ruta); /* Remplaza el avatar por el nuevo avatar */
                $('#edit').hide('slow');
                $('#edit').show(1500);
                $('#edit').hide(1500);
                $('#form-photo').trigger('reset');
                buscar_usuario(id_usuario); /* Permitira refrescar todos los datos del usuario */
            } else {
                $('#noedit').hide('slow');
                $('#noedit').show(1500);
                $('#noedit').hide(1500);
                $('#form-photo').trigger('reset');
            }
             
        });

        e.preventDefault();
    });
});

