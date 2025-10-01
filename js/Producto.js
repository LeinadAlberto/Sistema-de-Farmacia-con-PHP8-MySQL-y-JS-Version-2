$(document).ready(function() {

    var funcion = '';

    var edit = false;

    /* Sentencia que permite inicializar el uso de la libreria select2 */
    $('.select2').select2();

    rellenar_laboratorios();

    rellenar_tipos();

    rellenar_presentaciones();

    rellenar_proveedores();

    buscar_producto();

    function rellenar_laboratorios() {

        funcion = 'rellenar_laboratorios';

        $.post('../controlador/LaboratorioController.php', {funcion}, (response) => {

            const laboratorios = JSON.parse(response);

            let template = ``;

            laboratorios.forEach(laboratorio => {
                template += `
                    <option value="${laboratorio.id}">
                        ${laboratorio.nombre}
                    </option>
                `;
            });

            $('#laboratorio').html(template);

        });
    }

    function rellenar_tipos() {

        funcion = 'rellenar_tipos';

        $.post('../controlador/TipoController.php', {funcion}, (response) => {

            const tipos = JSON.parse(response);

            let template = ``;

            tipos.forEach(tipo => {
                template += `
                    <option value='${tipo.id}'>${tipo.nombre}</option>
                `;
            });

            $('#tipo').html(template);

        });
    }

    function rellenar_presentaciones() {

        funcion = 'rellenar_presentaciones';

        $.post('../controlador/PresentacionController.php', {funcion}, (response) => {

            const presentaciones = JSON.parse(response);

            let template = ``;

            presentaciones.forEach(presentacion => {
                template += `
                    <option value="${presentacion.id}">${presentacion.nombre}</option>
                `;
            });

            $('#presentacion').html(template);

        });
    }

    $('#form-crear-producto').submit(e => {

        let id = $('#id_edit_prod').val();
        let nombre = $('#nombre_producto').val();
        let concentracion = $('#concentracion').val();
        let adicional = $('#adicional').val();
        let precio = $('#precio').val();
        let laboratorio = $('#laboratorio').val();
        let tipo = $('#tipo').val();
        let presentacion = $('#presentacion').val();

        if (edit == true) {

            funcion = 'editar';

        } else {

            funcion = 'crear';

        }

        $.post('../controlador/ProductoController.php', 
                {nombre, concentracion, adicional, precio, laboratorio, tipo, presentacion, funcion, id}, 
                (response) => {

            if (response == 'add') {
                $('#add').hide('slow');
                $('#add').show(1200);
                $('#add').hide(1700);
                $('#form-crear-producto').trigger('reset');
                buscar_producto();
            }  

            if (response == 'edit') {
                $('#edit_prod').hide('slow');
                $('#edit_prod').show(1200);
                $('#edit_prod').hide(1700);
                $('#form-crear-producto').trigger('reset');
                buscar_producto();
            }  

            if (response == 'noadd') {
                $('#noadd').hide('slow');
                $('#noadd').show(1500);
                $('#noadd').hide(1700);
                $('#form-crear-producto').trigger('reset');
            }

            if (response == 'noedit') {
                $('#noadd').hide('slow');
                $('#noadd').show(2500);
                $('#noadd').hide(1700);
                $('#form-crear-producto').trigger('reset');
            }

            edit = false;

        });

        e.preventDefault();    

    });

    function buscar_producto(consulta) {

        funcion = "buscar";

        $.post("../controlador/ProductoController.php", {consulta, funcion}, (response) => {

            /* console.log(response); */

            const productos = JSON.parse(response);

            let template = ``; 

            productos.forEach(producto => {

                template += `
                    <div prodId="${producto.id}" 
                        prodNombre="${producto.nombre}" 
                        prodConcentracion="${producto.concentracion}" 
                        prodAdicional="${producto.adicional}" 
                        prodPrecio="${producto.precio}"  
                        prodLaboratorio="${producto.laboratorio_id}"
                        prodTipo="${producto.tipo_id}"
                        prodPresentacion="${producto.presentacion_id}"
                        prodAvatar="${producto.avatar}"
                        class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                    <div class="card bg-light">
                        <div class="card-header text-muted border-bottom-0 mb-2">
                            <i class="text-info fas fa-lg fa-cubes mr-1"></i>${producto.stock}
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${producto.nombre}</b></h2>
                                    <h4 class="lead"><b><i class="text-info fas fa-lg fa-dollar-sign mr-1"></i>${producto.precio} Bs.</b></h4> 
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-mortar-pestle mr-1"></i></span> <b>Concentración:</b> ${producto.concentracion}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-prescription-bottle-alt mr-1"></i></span> <b>Adicional:</b> ${producto.adicional}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-flask mr-1"></i></span> <b>Laboratorio:</b> ${producto.laboratorio}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-copyright mr-1"></i></span> <b>Tipo:</b> ${producto.tipo}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-pills mr-1"></i></span> <b>Presentación:</b> ${producto.presentacion}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${producto.avatar}" alt="" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button class="avatar btn btn-sm bg-teal mr-1" type="button" data-toggle="modal" data-target="#cambiologo">
                                    <i class="fas fa-image"></i>
                                </button>
                                <button class="editar btn btn-sm btn-success mr-1" type="button" data-toggle="modal" data-target="#crearproducto">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button class="lote btn btn-sm btn-primary mr-1" type="button" data-toggle="modal" data-target="#crearlote">
                                    <i class="fas fa-plus-square"></i>
                                </button>
                                <button class="borrar btn btn-sm btn-danger mr-1">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                `;
            });
            
            $('#productos').html(template); 
            
        });
    }

    $(document).on('keyup', '#buscar-producto', function() {

        let valor = $(this).val(); /* Almacena dentro la variable valor los datos que se ingresan dentro #buscar. */
        
        if (valor != '') {

            buscar_producto(valor);

        } else {

            buscar_producto();

        } 

    });

    $(document).on('click', '.avatar', (e) => {

        funcion = 'cambiar_avatar';

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('prodId');

        const avatar = $(elemento).attr('prodAvatar');

        const nombre = $(elemento).attr('prodNombre');

        $('#funcion').val(funcion);

        $('#id_logo_prod').val(id);

        $('#avatar').val(avatar);

        $('#logoactual').attr('src', avatar);

        $('#nombre_logo').html(nombre);

    });

    $('#form-logo').submit( e => {

        let formData = new FormData($('#form-logo')[0]);

        $.ajax({

            url: "../controlador/ProductoController.php",
            type: "post",
            data: formData,
            cache: false,
            processData: false,
            contentType: false

        }).done(function(response) {

            const json = JSON.parse(response);

            if (json.alert == 'edit') {
                $('#logoactual').attr('src', json.ruta);
                $('#edit').hide('slow');
                $('#edit').show(1200);
                $('#edit').hide(1700);
                $('#form-logo').trigger('reset');
                buscar_producto();
            } else {
                $('#noedit').hide('slow');
                $('#noedit').show(1200);
                $('#noedit').hide(1700);
                $('#form-logo').trigger('reset');
            }
        });

        e.preventDefault();

    });

    $(document).on('click', '.editar', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('prodId');
        const nombre = $(elemento).attr('prodNombre');
        const concentracion = $(elemento).attr('prodConcentracion');
        const adicional = $(elemento).attr('prodAdicional');
        const precio = $(elemento).attr('prodPrecio');
        const laboratorio = $(elemento).attr('prodLaboratorio');
        const tipo = $(elemento).attr('prodTipo');
        const presentacion = $(elemento).attr('prodPresentacion');

        $('#id_edit_prod').val(id);
        $('#nombre_producto').val(nombre);
        $('#concentracion').val(concentracion);
        $('#adicional').val(adicional);
        $('#precio').val(precio);
        $('#laboratorio').val(laboratorio).trigger('change');
        $('#tipo').val(tipo).trigger('change');
        $('#presentacion').val(presentacion).trigger('change');

        edit = true;

    });

    $(document).on('click', '.borrar', (e) => {

        funcion = 'borrar';

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('prodId');
        const nombre = $(elemento).attr('prodNombre');
        const avatar = $(elemento).attr('prodAvatar');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-2'
            },
            buttonsStyling: false
        })
          
        swalWithBootstrapButtons.fire({
            title: 'Estas seguro de eliminar el producto ' + nombre + '?',
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

                $.post('../controlador/ProductoController.php', {id, funcion}, (response) => {
                    
                    edit = false; 
                    
                    if (response == "borrado") {
                        swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El producto ' + nombre + ' ha sido eliminado.',
                            'success'
                        ) 
                        buscar_producto();
                    } else {
                        swalWithBootstrapButtons.fire(
                            '¡Proceso no realizado!',
                            'El producto ' + nombre + ' no se pudo eliminar porque esta siendo usado en un lote.',
                            'error'
                        )
                     }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El producto ' + nombre + ' no fue eliminado :)',
                    'error'
                )
            }
        })
    }); 

    $(document).on('click', '.lote', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('prodId');
        const nombre = $(elemento).attr('prodNombre');

        $('#id_lote_prod').val(id);
        $('#nombre_producto_lote').html(nombre);

    });

    function rellenar_proveedores() {

        funcion = 'rellenar_proveedores';

        $.post('../controlador/ProveedorController.php', {funcion}, (response) => {

            const proveedores = JSON.parse(response);

            let template = ``;

            proveedores.forEach(proveedor => {
                template += `
                    <option value="${proveedor.id}">${proveedor.nombre}</option>
                `;
            });

            $('#proveedor').html(template);

        });
        
    }

    /* Evento que permite enviar una petición al controlador de Lote, para crear un nuevo lote. */
    $('#form-crear-lote').submit((e) => {

        funcion = 'crear';

        let id_producto = $('#id_lote_prod').val();

        let proveedor = $('#proveedor').val();

        let stock = $('#stock').val();
        
        let vencimiento = $('#vencimiento').val();

        $.post('../controlador/LoteController.php', {funcion, id_producto, proveedor, stock, vencimiento}, (response) => {
            
            $('#add-lote').hide('slow');
            $('#add-lote').show(1200);
            $('#add-lote').hide(1700);
            $('#form-crear-lote').trigger('reset');

            buscar_producto();

        });

        e.preventDefault();

    });

    /* Evento para Reporte de Productos */
    $(document).on('click', '#button-reporte', (e) => {

        Mostrar_Loader('generarReportePDF');

        funcion = 'reporte_productos';

        $.post('../controlador/ProductoController.php', { funcion }, (response) => {

            if (response == '') {

                window.open('../pdf/pdf-' + funcion + '.pdf', '_blank');
                
                Cerrar_Loader('exito_reporte');

            } else {

                Cerrar_Loader('error_reporte');

            }

        }); 

    });

    function Mostrar_Loader(Mensaje) {

        var texto = null;

        var mostrar = false;

        switch (Mensaje) {

            case 'generarReportePDF':

                texto = 'Generando el reporte de Productos. Este proceso puede tardar unos instantes.';

                mostrar = true;

                break;
          
        }

        if (mostrar) {

            Swal.fire({

                title: 'Generando reporte',

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

            case 'exito_reporte':
                
                tipo = 'success';

                texto = 'Reporte de productos generado exitosamente.';

                mostrar = true;

            break;

            case 'error_reporte':
            
                tipo = 'error';

                texto = 'No se pudo completar la generación del reporte de productos. Inténtalo nuevamente o contacta a nuestro equipo de soporte.';

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