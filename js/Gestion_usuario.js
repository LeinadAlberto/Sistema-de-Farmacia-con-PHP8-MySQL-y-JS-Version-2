$(document).ready(function() {

    var tipo_usuario = $('#tipo_usuario').val();
    /* console.log(tipo_usuario); */

    /* Oculta el boton adicionar usuario, para los que son usuarios tipo técnico */
    if (tipo_usuario == 2) {
        $('#button-crear').hide();
    }

    /* Lista todos los usuarios registrados. */
    buscar_datos();

    var funcion;

    function buscar_datos(consulta) {
        funcion = 'buscar_usuarios_adm';
        $.post('../controlador/UsuarioController.php', {consulta, funcion}, (response) => {
            /* console.log(response); */
            const usuarios = JSON.parse(response);
            let template = '';
            usuarios.forEach(usuario => {
                template += `
                    <div usuarioId="${usuario.id}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0 mb-2">`;
                                if (usuario.tipo_usuario == 3) {
                                    template += `<h1 class="badge badge-danger">${usuario.tipo}</h1>`;
                                }
                                if (usuario.tipo_usuario == 1) {
                                    template += `<h1 class="badge badge-warning">${usuario.tipo}</h1>`;
                                }
                                if (usuario.tipo_usuario == 2) {
                                    template += `<h1 class="badge badge-info">${usuario.tipo}</h1>`;
                                }
                template += `</div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>${usuario.nombre} ${usuario.apellidos}</b></h2>
                                        <p class="text-muted text-sm"><b>Sobre mi: </b>${usuario.adicional}</p>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-id-card mr-1"></i></span> <b>DNI:</b> ${usuario.dni}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-venus-mars mr-1"></i></span> <b>Género:</b> ${usuario.sexo}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-phone mr-1"></i></span> <b>Teléfono #:</b> ${usuario.telefono}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-birthday-cake mr-1"></i></span> <b>Edad:</b> ${usuario.edad}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-at mr-1"></i></span> <b>Correo Electrónico:</b> ${usuario.correo}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-building mr-1"></i></span> <b>Residencia:</b> ${usuario.residencia}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="${usuario.avatar}" alt="" class="img-circle img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">`;
                                /* Si el tipo usuario es root, realiza todas las acciones permitidas dentro el if por verdad */
                                if (tipo_usuario == 3) {
                                    /* Si el usuario es administrador o técnico, el root puede eliminarlo */
                                    if (usuario.tipo_usuario != 3) {
                                        template += `<a href="#" class="borrar-usuario btn btn-sm btn-danger mr-1" type="button" data-toggle="modal" data-target="#confirmar">
                                                        <i class="fas fa-user-times mr-1"></i> Eliminar
                                                    </a>`;
                                    }
                                    /* Si el usuario es un técnico el root lo puede ascender */
                                    if (usuario.tipo_usuario == 2) {
                                        template += `<a href="#" class="ascender btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#confirmar">
                                                        <i class="fas fa-sort-amount-up mr-1"></i> Ascender
                                                    </a>`;
                                    }
                                    /* Si el usuario es un administrador el root puede descenderlo */
                                    if (usuario.tipo_usuario == 1) {
                                        template += `<a href="#" class="descender btn btn-sm btn-secondary" type="button" data-toggle="modal" data-target="#confirmar">
                                                        <i class="fas fa-sort-amount-down mr-1"></i> Descender
                                                    </a>`;
                                    }
                                } else {
                                    if (tipo_usuario == 1 && usuario.tipo_usuario != 1 && usuario.tipo_usuario != 3) {
                                        template += `<a href="#" class="borrar-usuario btn btn-sm btn-danger" type="button" data-toggle="modal" data-target="#confirmar">
                                                        <i class="fas fa-user-times mr-1"></i> Eliminar
                                                    </a>`;
                                    }
                                }
                                
                                template +=`
                                </div>
                            </div>
                        </div>
                    </div>
                            `;
            });
            $('#usuarios').html(template);
        });
    } 
 
    $(document).on('keyup', '#buscar', function() {
        let valor = $(this).val(); /* Almacena dentro la variable valor los datos que se ingresan dentro #buscar. */
        /* console.log(valor); */
        if (valor != '') {
            buscar_datos(valor);
        } else {
            buscar_datos();
        } 
    });

    /* Código que permite realizar la petición al controlador para crear un usuario */
    $('#form-crear').submit(e => {
        let nombre = $('#nombre').val();
        let apellido = $('#apellido').val();
        let edad = $('#edad').val();
        let dni = $('#dni').val();
        let pass = $('#pass').val();

        funcion = 'crear_usuario';
        
        $.post('../controlador/UsuarioController.php', 
            {nombre, apellido, edad, dni, pass, funcion}, 
            (response) => {
                if (response == 'add') {
                    $('#add').hide('slow'); /* Oculta la alerta actual */
                    $('#add').show(1500); /* Muestra el nuevo alert  */
                    $('#add').hide(1500); /* Ocultar luego de 2 segundos */
                    $('#form-crear').trigger('reset'); /* Resetea todos los campos del formulario */
                    buscar_datos();
                } else {
                    $('#noadd').hide('slow');
                    $('#noadd').show(1500); 
                    $('#noadd').hide(1500); 
                    $('#form-crear').trigger('reset');
                }
        });
        e.preventDefault();
    });

    $(document).on('click', '.ascender', (e) => {
        /* Accede al elemento padre que tiene el id del usuario al cual ascender */
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        /* console.log(elemento); */
        const id = $(elemento).attr('usuarioId');/* Accede al valor del atributo usuarioId del elemento padre */
        /* console.log(id); */
        funcion = 'ascender';
        $('#id_user').val(id);
        $('#funcion').val(funcion);
    });

    $(document).on('click', '.descender', (e) => {
        /* Accede al elemento padre que tiene el id del usuario al cual ascender */
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        /* console.log(elemento); */
        const id = $(elemento).attr('usuarioId');/* Accede al valor del atributo usuarioId del elemento padre */
        /* console.log(id); */
        funcion = 'descender';
        $('#id_user').val(id);
        $('#funcion').val(funcion);
    });

    $(document).on('click', '.borrar-usuario', (e) => {
        /* Accede al elemento padre que tiene el id del usuario al cual ascender */
        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;
        /* console.log(elemento); */
        const id = $(elemento).attr('usuarioId');/* Accede al valor del atributo usuarioId del elemento padre */
        /* console.log(id); */
        funcion = 'borrar_usuario';
        $('#id_user').val(id);
        $('#funcion').val(funcion);
    });

    $('#form-confirmar').submit(e => {
        let pass = $('#oldpass').val();
        let id_usuario = $('#id_user').val();

        funcion = $('#funcion').val();

        $.post('../controlador/UsuarioController.php', {pass, id_usuario, funcion}, (response) => {
            if (response == 'ascendido' || response == 'descendido' || response == 'borrado') {
                $('#confirmado').hide('slow');
                $('#confirmado').show(1500); 
                $('#confirmado').hide(1500); 
                $('#form-confirmar').trigger('reset');
            } else {
                $('#rechazado').hide('slow');
                $('#rechazado').show(1500); 
                $('#rechazado').hide(1500); 
                $('#form-confirmar').trigger('reset');
            }

            buscar_datos();
        });

        e.preventDefault();
    });
});