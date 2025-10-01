$(document).ready(function() {

    var funcion = '';

    buscar_lote();

    function buscar_lote(consulta) {

        funcion = "buscar";

        $.post("../controlador/LoteController.php", {consulta, funcion}, (response) => {

            const lotes = JSON.parse(response);

            let template = ``;

            lotes.forEach(lote => {

                template += `
                    <div loteID="${lote.id}" loteStock="${lote.stock}" class="mt-3 col-12 col-sm-6 col-md-4 d-flex align-items-stretch">`;
                    if (lote.estado == 'light') {
                        template += `<div class="card bg-light">`;
                    }
                    if (lote.estado == 'danger') {
                        template += `<div style="background: #960944; !important">`;
                    }
                    if (lote.estado == 'warning') {
                        template += `<div class="card bg-warning">`;
                    }
                template += `<div class="card-header border-bottom-0 mb-2">
                            <h6>Código ${lote.id}</h6>
                            <i class="fas fa-lg fa-cubes mr-1"></i>${lote.stock}
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b>${lote.nombre}</b></h2> 
                                    <ul class="ml-4 mb-0 fa-ul">
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-mortar-pestle mr-1"></i></span> <b>Concentración:</b> ${lote.concentracion}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-prescription-bottle-alt mr-1"></i></span> <b>Adicional:</b> ${lote.adicional}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-flask mr-1"></i></span> <b>Laboratorio:</b> ${lote.laboratorio}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-copyright mr-1"></i></span> <b>Tipo:</b> ${lote.tipo}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-pills mr-1"></i></span> <b>Presentación:</b> ${lote.presentacion}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-calendar-times mr-1"></i></span> <b>Vencimiento:</b> ${lote.vencimiento}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-truck mr-1"></i></span> <b>Proveedor:</b> ${lote.proveedor}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-calendar-alt mr-1"></i></span> <b>Mes:</b> ${lote.mes}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-calendar-day mr-1"></i></span> <b>Dia:</b> ${lote.dia}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                        <li class="small"><span class="fa-li"><i class="text-info fas fa-lg fa-calendar-day mr-1"></i></span> <b>Estado:</b> ${lote.estado}</li>
                                        <hr class="mt-1 mb-1 bg-info">
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="${lote.avatar}" alt="" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <button class="editar btn btn-sm btn-success mr-1" type="button" data-toggle="modal" data-target="#editarlote">
                                    <i class="fas fa-pencil-alt"></i>
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
            
            $('#lotes').html(template);
            
        });
    }

    $(document).on('keyup', '#buscar-lote', function() {
        let valor = $(this).val(); 
        console.log(valor);
        if (valor != '') {
            buscar_lote(valor);
        } else {
            buscar_lote();
        } 
    });

    $(document).on('click', '.editar', (e) => {

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('loteId');

        const stock = $(elemento).attr('loteStock');

        $('#codigo_lote').html(id);

        $('#stock').val(stock);

        $('#id_lote_prod').val(id);

    });

    $('#form-editar-lote').submit((e) => {

        let id = $('#id_lote_prod').val();

        let stock = $('#stock').val();

        funcion = 'editar';

        $.post('../controlador/LoteController.php', {funcion, id, stock}, (response) => {

            if (response == 'edit') {
                $('#edit-lote').hide('slow');
                $('#edit-lote').show(1200);
                $('#edit-lote').hide(1700);
                $('#form-editar-lote').trigger('reset'); 
            } 

            buscar_lote();

        });

        e.preventDefault();   

    });

    $(document).on('click', '.borrar', (e) => {

        funcion = 'borrar';

        const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement.parentElement;

        const id = $(elemento).attr('loteId');

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger mr-2'
            },
            buttonsStyling: false
        })
          
        swalWithBootstrapButtons.fire({

            title: 'Estas seguro de eliminar el lote ' + id + '?',
            text: '¡No podrás revertir esto!',
            icon: 'warning', 
            showCancelButton: true,
            confirmButtonText: '¡Sí, bórralo!',
            cancelButtonText: '¡No, cancela!',
            reverseButtons: true
            
        }).then((result) => {

            if (result.isConfirmed) {

                $.post('../controlador/LoteController.php', {id, funcion}, (response) => { 

                    if (response == "borrado") {

                        swalWithBootstrapButtons.fire(
                            '¡Eliminado!',
                            'El lote ' + id + ' ha sido eliminado.',
                            'success'
                        ) 

                        buscar_lote();

                    } else {

                        swalWithBootstrapButtons.fire(
                            '¡Proceso no realizado!',
                            'El lote ' + id + ' no se pudo eliminar porque esta siendo usado.',
                            'error'
                        )

                     }

                });

            } else if (result.dismiss === Swal.DismissReason.cancel) {

                swalWithBootstrapButtons.fire(
                    'Cancelado',
                    'El lote ' + id + ' no fue eliminado :)',
                    'error'
                )

            }

        })

    });

});