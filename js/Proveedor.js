$(document).ready(function() {

    var edit = false;

    var funcion;

    buscar_prov();

    $('#form-crear').submit(e => {

        let id = $('#id_edit_prov').val();

        let nombre = $('#nombre').val();
        let telefono = $('#telefono').val();
        let correo = $('#correo').val();
        let direccion = $('#direccion').val();

        if (edit == true) {

            funcion = 'editar';

        } else {

            funcion = "crear";

        }

        $.post('../controlador/ProveedorController.php', {funcion, nombre, telefono, correo, direccion, id}, (response) => {
            
            if (response == "add") {
                $('#add-prov').hide('slow');
                $('#add-prov').show(1200);
                $('#add-prov').hide(1700);
                $('#form-crear').trigger('reset');

                buscar_prov();
            }

            if (response == "noadd" || response == "noedit") {
                $('#noadd-prov').hide('slow');
                $('#noadd-prov').show(1200);
                $('#noadd-prov').hide(1700);
                $('#form-crear').trigger('reset');
            }

            if (response == "edit") {
                $('#edit-prove').hide('slow');
                $('#edit-prove').show(1200);
                $('#edit-prove').hide(1700);
                $('#form-crear').trigger('reset');
                
                buscar_prov();
            }

            edit = false;

        });

        e.preventDefault();

    });

    function buscar_prov(consulta) {

        funcion = 'buscar';

        $.post('../controlador/ProveedorController.php', {funcion, consulta}, (response) => {
            
            const proveedores = JSON.parse(response);
            
            let template = '';
            
            proveedores.forEach(proveedor => {
                
                template += `
                    <div provId="${proveedor.id}" 
                        provNombre="${proveedor.nombre}" 
                        provDireccion="${proveedor.direccion}"
                        provTelefono="${proveedor.telefono}"
                        provCorreo="${proveedor.correo}"
                        provAvatar="${proveedor.avatar}"
                        class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                        <div class="card bg-light">
                            <div class="card-header text-muted border-bottom-0 mb-2">
                                <h1 class="badge badge-success">Proveedor</h1>   
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>${proveedor.nombre}</b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-building mr-1"></i></span> <b>Dirección:</b> ${proveedor.direccion}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-phone mr-1"></i></span> <b>Teléfono #:</b> ${proveedor.telefono}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                            <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-at mr-1"></i></span> <b>Correo Electrónico:</b> ${proveedor.correo}</li>
                                            <hr class="mt-1 mb-1 bg-info">
                                        </ul>
                                    </div>
                                    <div class="col-5 text-center">
                                        <img src="${proveedor.avatar}" alt="" class="img-circle img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="avatar btn btn-sm btn-info mr-1" title="Editar Logo" type="button" data-toggle="modal" data-target="#cambiologo">
                                        <i class="fas fa-image"></i>
                                    </button>
                                    <button class="editar btn btn-sm btn-success mr-1" title="Editar Proveedor" type="button" data-toggle="modal" data-target="#crearproveedor">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                    <button class="borrar btn btn-sm btn-danger mr-1" title="Eliminar Proveedor">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

            $('#proveedores').html(template);

        });
    }

    $(document).on('keyup', '#buscar_proveedor', function() {

        let valor = $(this).val();

        if (valor != '') {

            buscar_prov(valor);

        } else {

            buscar_prov();

        }

    });

    $(document).on('click', '.avatar', (e) => {

        funcion = 'cambiar_logo';

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('provId');
        const nombre = $(elemento).attr('provNombre');
        const avatar = $(elemento).attr('provAvatar');
     
        $('#logoactual').attr('src', avatar);
        $('#nombre_logo').html(nombre);
        $('#funcion').val(funcion);
        $('#id_logo_prov').val(id);
        $('#avatar').val(avatar);

    });

    $(document).on('click', '.editar', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('provId');
        const nombre = $(elemento).attr('provNombre');
        const telefono = $(elemento).attr('provTelefono');
        const correo = $(elemento).attr('provCorreo');
        const direccion = $(elemento).attr('provDireccion');

        $('#id_edit_prov').val(id);
        $('#nombre').val(nombre);
        $('#telefono').val(telefono);
        $('#correo').val(correo);
        $('#direccion').val(direccion);

        edit = true;

    });

    $('#form-logo').submit( e => {

        let formData = new FormData($('#form-logo')[0]);

        $.ajax({

            url: "../controlador/ProveedorController.php",
            type: "post",
            data: formData,
            cache: false,
            processData: false,
            contentType: false

        }).done(function(response) {

            const json = JSON.parse(response);

            if (json.alert == 'edit') {

                $('#logoactual').attr('src', json.ruta);
                $('#edit-prov').hide('slow');
                $('#edit-prov').show(1200);
                $('#edit-prov').hide(1700);
                $('#form-logo').trigger('reset');

                buscar_prov();

            } else {

                $('#noedit-prov').hide('slow');
                $('#noedit-prov').show(1200);
                $('#noedit-prov').hide(1700);
                $('#form-logo').trigger('reset');

            }

        });

        e.preventDefault();

    });

    $(document).on('click', '.borrar', (e) => {

        funcion = 'borrar';

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('provId');
        const nombre = $(elemento).attr('provNombre');
        const avatar = $(elemento).attr('provAvatar');
       
        const swalWithBootstrapButtons = Swal.mixin({

            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-2'
            },

            buttonsStyling: false

        })
          
        swalWithBootstrapButtons.fire({

            title: 'Estas seguro de eliminar el proveedor ' + nombre + '?',
            text: "¡No podrás revertir esto!",
            imageUrl: '' + avatar + '',
            imageWidth: 100,
            imageHeight: 100, 
            showCancelButton: true,
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: '¡No, cancela!',
            reverseButtons: true

        }).then((result) => {

            if (result.isConfirmed) {

                $.post('../controlador/ProveedorController.php', {id, funcion}, (response) => {

                    edit = false; 

                    if (response == "borrado") {

                        swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El proveedor ' + nombre + ' ha sido eliminado.',
                            'success'
                        ) 

                        buscar_prov();

                    } else {

                        swalWithBootstrapButtons.fire(
                            '¡Proceso no realizado!',
                            'El proveedor ' + nombre + ' no se pudo eliminar porque esta siendo usado en un Lote',
                            'error'
                        )

                     }

                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {

                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El proveedor ' + nombre + ' no fue eliminado :)',
                    'error'
                )

            }

        })

    }); 

});