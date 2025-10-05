<?php 
    session_start();
    if ($_SESSION["us_tipo"] == 1 || $_SESSION["us_tipo"] == 3) {

        include_once "layouts/header.php";
?>

    <title>Gestión Producto</title>
        
<?php include_once "layouts/nav.php"; ?>

<!-- Modal para seleccionar Formato del Reporte de Productos -->
<div class="modal fade" id="modalFormatoReporte" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-info">

                <div class="card-header">
                    <h3 class="card-title">Elegir el formato del Reporte</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /.card-header -->
                
                <div class="card-body">
    
                    <div class="form-group d-flex justify-content-sm-around">
                        <button id="button-reporte" class="btn btn-outline-danger">Formato PDF <i class="far fa-file-pdf ml-2"></i></button>
                        <button class="btn btn-outline-success">Formato Excel<i class="far fa-file-excel ml-2"></i></button>
                    </div>

                </div><!-- /.card-body -->

            </div><!-- /.card -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para Crear Lote -->
<div class="modal fade" id="crearlote" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Crear Lote</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /.card-header -->
                
                <form id="form-crear-lote">
                    <div class="card-body">
                        <!-- Mensajes de Alerta -->
                        <div class="alert alert-success text-center" id="add-lote" style="display:none;">
                            <span><i class="fas fa-thumbs-up m-1"></i> Lote registrado con exito</span>
                        </div>
                        <!-- Fin Mensajes de Alerta -->

                        <!-- Producto -->
                        <div class="form-group">
                            <label>Producto: </label>
                            <span id="nombre_producto_lote" class="ml-2 text-info">Nombre de Producto</span>
                        </div>

                        <!-- Proveedor -->
                        <div class="form-group">
                            <label for="proveedor">Proveedor</label>
                            <select id="proveedor" class="form-control select2" style="width: 100%;"></select>
                        </div>

                        <!-- Stock -->
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input id="stock" type="number" class="form-control" placeholder="Ingrese stock" required>
                        </div>

                        <!-- Fecha de Vencimiento -->
                        <div class="form-group">
                            <label for="vencimiento">Fecha de vencimiento: </label>
                            <input id="vencimiento" type="date" class="form-control" placeholder="Ingrese fecha de vencimiento" required>
                        </div>

                        <!-- ID del Producto -->
                        <input type="hidden" id="id_lote_prod">
                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right m-1">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                    </div><!-- /.card-footer -->
                </form>
            </div><!-- /.card -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Modal para cambiar la Imágen de un Producto -->
<div class="modal fade" id="cambiologo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Logo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <img id="logoactual" src="../img/avatar.png" alt="Imágen del Producto" class="profile-user-img img-fluid img-circle">
                </div>
                <div class="text-center">
                    <b id="nombre_logo"></b>
                </div>

                <!-- Mensajes de Alerta -->
                <div class="alert alert-success text-center" id="edit" style="display:none;">
                    <span><i class="fas fa-thumbs-up m-1"></i> Logo cambiado con exito</span>
                </div>
                <div class="alert alert-danger text-center" id="noedit" style="display:none;">
                    <span><i class="fas fa-exclamation-triangle m-1"></i> <b>Formato de imágen no permitido</b></span>
                </div>
                <!-- Fin Mensajes de Alerta -->

                <!-- form-data permite el envio de datos por medio del atributo name de cada elemento -->
                <form id="form-logo" enctype="multipart/form-data">
                    <div class="input-group ml-5 mb-3 mt-3">
                        <input type="file" name="photo" class="input-group ml-5 ">
                        <input type="hidden" name="funcion" id="funcion">
                        <input type="hidden" name="id_logo_prod" id="id_logo_prod">
                        <input type="hidden" name="avatar" id="avatar">
                    </div><!-- /.input-group -->

            </div><!-- /.modal-body -->

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<!-- Modal para Crear y Editar Producto -->
<div class="modal fade" id="crearproducto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Crear producto</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /.card-header -->

                <form id="form-crear-producto">
                    <div class="card-body">
                        <!-- Mensajes de Alerta -->
                        <div class="alert alert-success text-center" id="add" style="display:none;">
                            <span><i class="fas fa-thumbs-up m-1"></i> Producto registrado con exito</span>
                        </div>

                        <div class="alert alert-danger text-center" id="noadd" style="display:none;">
                            <span><i class="fas fa-exclamation-triangle m-1"></i> <b>¡Acción no permitida!. El Producto ya existe.</b></span>
                        </div>

                        <div class="alert alert-success text-center" id="edit_prod" style="display:none;">
                            <span><i class="fas fa-thumbs-up m-1"></i> Producto editado con exito</span>
                        </div>
                        <!-- Fin Mensajes de Alerta -->

                        <!-- Nombre -->
                        <div class="form-group">
                            <label for="nombre_producto">Nombre</label>
                            <input id="nombre_producto" type="text" class="form-control" placeholder="Ingrese nombre" required>
                        </div>

                        <!-- Concentración -->
                        <div class="form-group">
                            <label for="concentracion">Concentración</label>
                            <input id="concentracion" type="text" class="form-control" placeholder="Ingrese concentración">
                        </div>

                        <!-- Adicional -->
                        <div class="form-group">
                            <label for="adicional">Adicional</label>
                            <input id="adicional" type="text" class="form-control" placeholder="Ingrese información adicional">
                        </div>

                        <!-- Precio -->
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            
                            <!-- El atributo step con el valor any permite ingresar valores decimales en el input -->
                            <input id="precio" type="number" step="any" class="form-control" value="1" placeholder="Ingrese precio" required>
                        </div>

                        <!-- Laboratorio -->
                        <div class="form-group">
                            <label for="laboratorio">Laboratorio</label>
                            <select id="laboratorio" class="form-control select2" style="width: 100%;"></select>
                        </div>

                        <!-- Tipo -->
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select id="tipo" class="form-control select2" style="width: 100%;"></select>
                        </div>

                        <!-- Presentación -->
                        <div class="form-group">
                            <label for="presentacion">Presentación</label>
                            <select id="presentacion" class="form-control select2" style="width: 100%;"></select>
                        </div>

                        <!-- Envia el id del Producto al Controlador -->
                        <input type="hidden" id="id_edit_prod">
                    </div><!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-info float-right m-1">Guardar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                    </div><!-- /.card-footer -->
                </form>
            </div><!-- /.card -->
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <h1>Gestión productos 
                        <button id="button-crear" type="button" data-toggle="modal" data-target="#crearproducto" class="btn btn-outline-info ml-2">
                            Crear Producto
                        </button>

                        <!-- id="button-reporte" -->
                        <button type="button" data-toggle="modal" data-target="#modalFormatoReporte" class="btn btn-outline-success ml-2">
                            Reporte de Productos
                        </button>
                    </h1>
                </div>
                <div class="col-sm-4">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión producto</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content-header -->

    <section>
        <div class="container-fluid">
            <card class="card card-info">
                <div class="card-header">
                    <h3 class="card-title mb-2">Buscar producto</h3>
                    <div class="input-group">
                        <input id="buscar-producto" type="text" class="form-control float-left" placeholder="Ingrese nombre del producto...">
                        <div class="input-group-append">
                            <button class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div> 
                </div><!-- /.card-header -->

                <div class="card-body">
                    <div id="productos" class="row d-flex align-items-stretch">

                    </div>
                </div><!-- /.card-body -->

                <div class="card-footer">

                </div><!-- /.card-footer -->
            </card>
        </div>
    </section>
    
</div><!-- /.content-wrapper -->


<?php 
        include_once "layouts/footer.php";

    } else { // Closed if
        header("Location: ../index.php");
    }  
?>

<script src="../js/Producto.js"></script>