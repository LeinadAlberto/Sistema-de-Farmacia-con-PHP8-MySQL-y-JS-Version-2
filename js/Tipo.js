$(document).ready(function() {
    buscar_tip();
    var funcion = '';
    var edit = false;

    /* Crear y Editar Tipo */
    $('#form-crear-tipo').submit(e => {
        let nombre_tipo = $('#nombre-tipo').val();
        let id_editado = $('#id_editar_tip').val();
        /* Si la variable editar tiene el valor de false se crea un tipo, caso contrario se edita */
        if (edit == false) {
            funcion = 'crear';
        } else {
            funcion = 'editar';
        }
        $.post('../controlador/TipoController.php', {nombre_tipo, id_editado, funcion}, (response) => {
            if (response == "add") {
                $('#add-tipo').hide('slow');
                $('#add-tipo').show(1200);
                $('#add-tipo').hide(1700);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            } 
            if (response == "noadd") {
                $('#noadd-tipo').hide('slow');
                $('#noadd-tipo').show(1200);
                $('#noadd-tipo').hide(1700);
                $('#form-crear-tipo').trigger('reset');
            }
            if (response == "edit") {
                $('#edit-tip').hide('slow');
                $('#edit-tip').show(1200);
                $('#edit-tip').hide(1700);
                $('#form-crear-tipo').trigger('reset');
                buscar_tip();
            }
            edit = false;
        });
        e.preventDefault();
    });

    function buscar_tip(consulta) {
        funcion = 'buscar';
        $.post('../controlador/TipoController.php', {consulta, funcion}, (response) => {
            const tipos = JSON.parse(response);
            let template = '';
            tipos.forEach(tipo => {
                template += `
                    <tr tipId="${tipo.id}" tipNombre="${tipo.nombre}">
                        <td>${tipo.nombre}</td>
                        <td>
                            <button class="editar-tip btn btn-success" title="Editar tipo" type="button" data-toggle="modal" data-target="#creartipo">
                                <i class="fas fa-pencil-alt"></i>
                            </button>

                            <button class="borrar-tip btn btn-danger" title="Eliminar tipo">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#tipos').html(template);
        });
    }

    $(document).on('keyup', '#buscar-tipo', function() {
        let valor = $(this).val();
        if (valor != '') {
            buscar_tip(valor);
        } else {
            buscar_tip();
        }
    });

    $(document).on('click', '.borrar-tip', (e) => {
        funcion = 'borrar';
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        /* console.log(elemento); */
        const id = $(elemento).attr('tipId');
        const nombre = $(elemento).attr('tipNombre');
    
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-2'
            },
            buttonsStyling: false
        })
          
        swalWithBootstrapButtons.fire({
            title: 'Estas seguro de eliminar Tipo ' + nombre + '?',
            text: "¡No podrás revertir esto!",
            icon: 'warning', 
            showCancelButton: true,
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: '¡No, cancela!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('../controlador/TipoController.php', {id, funcion}, (response) => {
                    edit = false;
                    /* console.log(response); */
                    if (response == "borrado") {
                        swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El tipo ' + nombre + ' ha sido eliminado.',
                            'success'
                        ) 
                        buscar_tip();
                    } else {
                        swalWithBootstrapButtons.fire(
                            '¡Proceso no realizado!',
                            'El tipo ' + nombre + ' no se pudo eliminar porque esta siendo usado en un producto.',
                            'error'
                        )
                     }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El tipo ' + nombre + ' no fue eliminado :)',
                    'error'
                )
            }
        })
       
       
    });

    $(document).on('click', '.editar-tip', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('tipId');
        const nombre = $(elemento).attr('tipNombre');
        $('#id_editar_tip').val(id);
        $('#nombre-tipo').val(nombre);
        edit = true;
    });

});