$(document).ready(function() {
    buscar_pre();
    var funcion = '';
    var edit = false;

    /* Crear y Editar Presentación */
    $('#form-crear-presentacion').submit(e => {
        let nombre_presentacion = $('#nombre-presentacion').val();
        let id_editado = $('#id_editar_pre').val();
        /* Si la variable editar tiene el valor de false se crea una Presentación, caso contrario se edita */
        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }
        $.post('../controlador/PresentacionController.php', {nombre_presentacion, id_editado, funcion}, (response) => {
            if (response == "add") {
                $('#add-pre').hide('slow');
                $('#add-pre').show(1200);
                $('#add-pre').hide(1700);
                $('#form-crear-presentacion').trigger('reset');
                buscar_pre();
            } 
            if (response == "noadd") {
                $('#noadd-pre').hide('slow');
                $('#noadd-pre').show(1200);
                $('#noadd-pre').hide(1700);
                $('#form-crear-presentacion').trigger('reset');
            }
            if (response == "edit") {
                $('#edit-pre').hide('slow');
                $('#edit-pre').show(1200);
                $('#edit-pre').hide(1700);
                $('#form-crear-presentacion').trigger('reset');
                buscar_pre();
            }
            edit = false;
        });
        e.preventDefault();
    });

    function buscar_pre(consulta) {
        funcion = 'buscar';
        $.post('../controlador/PresentacionController.php', {consulta, funcion}, (response) => {
            const presentaciones = JSON.parse(response);
            let template = '';
            presentaciones.forEach(presentacion => {
                template += `
                    <tr preId="${presentacion.id}" preNombre="${presentacion.nombre}">
                        <td>${presentacion.nombre}</td>
                        <td>
                            <button class="editar-pre btn btn-success" title="Editar presentacion" type="button" data-toggle="modal" data-target="#crearpresentacion">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button class="borrar-pre btn btn-danger" title="Eliminar presentacion">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#presentaciones').html(template);
        });
    }

    $(document).on('keyup', '#buscar-presentacion', function() {
        let valor = $(this).val();
        if (valor != '') {
            buscar_pre(valor);
        } else {
            buscar_pre();
        }
    });

    $(document).on('click', '.borrar-pre', (e) => {
        funcion = 'borrar';
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        /* console.log(elemento); */
        const id = $(elemento).attr('preId');
        const nombre = $(elemento).attr('preNombre');
    
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-2'
            },
            buttonsStyling: false
        })
          
        swalWithBootstrapButtons.fire({
            title: 'Estas seguro de eliminar Presentación ' + nombre + '?',
            text: "¡No podrás revertir esto!",
            icon: 'warning', 
            showCancelButton: true,
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: '¡No, cancela!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/PresentacionController.php', {id, funcion}, (response) => {
                    edit = false;
                    /* console.log(response); */
                    if (response == "borrado") {
                        swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'La presentación ' + nombre + ' ha sido eliminada.',
                            'success'
                        ) 
                        buscar_pre();
                    } else {
                        swalWithBootstrapButtons.fire(
                            '¡Proceso no realizado!',
                            'La presentación ' + nombre + ' no se pudo eliminar porque esta siendo usado en un producto.',
                            'error'
                        )
                     }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'La presentación ' + nombre + ' no fue eliminada :)',
                    'error'
                )
            }
        })
       
       
    });

    $(document).on('click', '.editar-pre', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('preId');
        const nombre = $(elemento).attr('preNombre');
        $('#id_editar_pre').val(id);
        $('#nombre-presentacion').val(nombre);
        edit = true;
    });

});