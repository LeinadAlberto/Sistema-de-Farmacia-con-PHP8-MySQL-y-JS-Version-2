$(document).ready(function() {

    /* Permite visualizar el componente carrito en la vista de Administrar Catalogo */
    $('#cat-carrito').show();

    mostrar_lotes_riesgo();

    buscar_producto();

    /* Obtiene los Lotes de Productos que su fecha de Expiración vencio o esta a punto de vencer. */
    function mostrar_lotes_riesgo() {

        funcion = 'buscar';

        $.post('../controlador/LoteController.php', {funcion}, (response) => {

            const lotes = JSON.parse(response);
            
            /* console.log("========== INICIO - Mostrando lotes en riesgo ==========");
            console.log(lotes);
            console.log("========== FIN - Mostrando lotes en riesgo =========="); */
            
            let template = ``;

            lotes.forEach(lote => {

                if (lote.estado == 'warning') {

                    template += `
                        <tr class="table-warning">
                            <td>${lote.id}</td>
                            <td>${lote.nombre}</td>
                            <td>${lote.stock}</td>
                            <td>${lote.laboratorio}</td>
                            <td>${lote.presentacion}</td>
                            <td>${lote.proveedor}</td>
                            <td>${lote.mes}</td>
                            <td>${lote.dia}</td>
                        </tr>
                    `;

                }

                if (lote.estado == 'danger') {

                    template += `
                        <tr class="table-danger">
                            <td>${lote.id}</td>
                            <td>${lote.nombre}</td>
                            <td>${lote.stock}</td>
                            <td>${lote.laboratorio}</td>
                            <td>${lote.presentacion}</td>
                            <td>${lote.proveedor}</td>
                            <td>${lote.mes}</td>
                            <td>${lote.dia}</td>
                        </tr>
                    `;

                }

            });

            $('#lotes').html(template);

        });

    }

    function buscar_producto(consulta) {

        funcion = "buscar";

        $.post("../controlador/ProductoController.php", {consulta, funcion}, (response) => {

            const productos = JSON.parse(response);

            let template = ``;

            productos.forEach(producto => {

                template += `
                    <div prodId="${producto.id}" 
                        prodStock="${producto.stock}"
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
                                        <h2 class="lead">Código: <b>${producto.id}</b></h2>
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
                                    <button class="agregar-carrito btn btn-sm btn-info mr-1">
                                        <i class="fas fa-plus-square mr-2"></i> Añadir al carrito
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

        let valor = $(this).val(); /* Almacena dentro la variable llamada valor los datos que se ingresan dentro el input con id='buscar-producto'. */
        
        if (valor != '') {

            buscar_producto(valor);

        } else {

            buscar_producto();

        } 

    });

});