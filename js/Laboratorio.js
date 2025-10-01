$(document).ready(function() {

    buscar_lab();
    
    var funcion = '';

    var edit = false;

    $('#form-crear-laboratorio').submit(e => {

        let nombre_laboratorio = $('#nombre-laboratorio').val();

        let id_editado = $('#id_editar_lab').val();

        /* Si la variable editar tiene el valor de false se crea un laboratorio, caso contrario se edita */
        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }

        $.post('../controlador/LaboratorioController.php', {nombre_laboratorio, id_editado, funcion}, (response) => {
            
            if (response == "add") {
                $('#add-laboratorio').hide('slow');
                $('#add-laboratorio').show(1200);
                $('#add-laboratorio').hide(1700);
                $('#form-crear-laboratorio').trigger('reset');
                buscar_lab();
            } 

            if (response == "noadd") {
                $('#noadd-laboratorio').hide('slow');
                $('#noadd-laboratorio').show(1200);
                $('#noadd-laboratorio').hide(1700);
                $('#form-crear-laboratorio').trigger('reset');
            }

            if (response == "edit") {
                $('#edit-lab').hide('slow');
                $('#edit-lab').show(1200);
                $('#edit-lab').hide(1700);
                $('#form-crear-laboratorio').trigger('reset');
                buscar_lab();
            }

            edit = false;

        });

        e.preventDefault();

    });

    function buscar_lab(consulta) {
        funcion = 'buscar';
        $.post('../controlador/LaboratorioController.php', {consulta, funcion}, (response) => {
            const laboratorios = JSON.parse(response);
            let template = '';
            laboratorios.forEach(laboratorio => {
                template += `
                    <tr labId="${laboratorio.id}" labNombre="${laboratorio.nombre}" labAvatar="${laboratorio.avatar}">
                        <td>${laboratorio.nombre}</td>
                        <td>
                            <img src="${laboratorio.avatar}" class="img-fluid rounded" width="70" height="70">
                        </td>
                        <td>
                            <button class="avatar btn btn-info" title="Cambiar logo de laboratorio" type="button" data-toggle="modal" data-target="#cambiologo">
                                <i class="far fa-image"></i>
                            </button>

                            <button class="editar btn btn-success" title="Editar laboratorio" type="button" data-toggle="modal" data-target="#crearlaboratorio">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button class="borrar btn btn-danger" title="Eliminar laboratorio">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#laboratorios').html(template);
        });
    }

    $(document).on('keyup', '#buscar-laboratorio', function() {

        let valor = $(this).val();

        if (valor != '') {
            buscar_lab(valor);
        } else {
            buscar_lab();
        }
    });

    $(document).on('click', '.avatar', (e) => {
        funcion = 'cambiar_logo';
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        /* console.log(elemento); */
        const id = $(elemento).attr('labid');
        const nombre = $(elemento).attr('labnombre');
        const avatar = $(elemento).attr('labavatar');
        /* console.log(`${id} - ${nombre} - ${avatar}`) */
        $('#logoactual').attr('src', avatar);
        $('#nombre_logo').html(nombre);
        $('#funcion').val(funcion);
        $('#id_logo_lab').val(id);
    });

    /* Uso de FormData para cambio de avatar. */
    $('#form-logo').submit(e => {
        let formData = new FormData($('#form-logo')[0]);
        $.ajax({
            url: '../controlador/LaboratorioController.php',
            type: 'POST',
            data: formData,
            cache: false,
            processData: false,
            contentType: false
        }).done(function(response) {
            const json = JSON.parse(response);
            if (json.alert == 'edit')  {
                $('#logoactual').attr('src', json.ruta);
                $('#form-logo').trigger('reset');
                $('#edit').hide('slow');
                $('#edit').show(1000);
                $('#edit').hide(2000);
                buscar_lab();
            } else {
                $('#noedit').hide('slow');
                $('#noedit').show(1000);
                $('#noedit').hide(2000);
                $('#form-logo').trigger('reset');
            }
        });

        e.preventDefault();
    });

    $(document).on('click', '.borrar', (e) => {

        funcion = 'borrar';

        const elemento = $(this)[0].activeElement.parentElement.parentElement;
       
        const id = $(elemento).attr('labid');

        const nombre = $(elemento).attr('labnombre');

        const avatar = $(elemento).attr('labavatar');
        
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-2'
            },
            buttonsStyling: false
        })
          
        swalWithBootstrapButtons.fire({
            title: 'Estas seguro de eliminar Laboratorio ' + nombre + '?',
            text: '¡No podrás revertir esto!',
            imageUrl: '' + avatar + '',
            imageWidth: 100,
            imageHeight: 100, 
            /* icon: 'warning', */
            showCancelButton: true,
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: '¡No, cancela!',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                $.post('../controlador/LaboratorioController.php', {id, funcion}, (response) => {

                    edit = false;

                    if (response == "borrado") {
                        swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El laboratorio ' + nombre + ' ha sido eliminado.',
                            'success'
                        ) 
                        buscar_lab();
                    } else {
                        swalWithBootstrapButtons.fire(
                            '¡Proceso no realizado!',
                            'El laboratorio ' + nombre + ' no se pudo eliminar porque esta siendo usado en un producto.',
                            'error'
                        )
                     }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El laboratorio ' + nombre + ' no fue eliminado :)',
                    'error'
                )
            }
        })
    });

    $(document).on('click', '.editar', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement;

        const id = $(elemento).attr('labid');

        const nombre = $(elemento).attr('labnombre');

        $('#id_editar_lab').val(id);

        $('#nombre-laboratorio').val(nombre);
        
        edit = true;

    });


});