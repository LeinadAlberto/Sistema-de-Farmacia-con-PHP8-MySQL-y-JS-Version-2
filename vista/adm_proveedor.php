<?php 
    session_start();

    if ($_SESSION["us_tipo"] == 1 || $_SESSION["us_tipo"] == 3) {

        include_once "layouts/header.php";
?>

    <title>Gestión Usuario</title>
        
<?php include_once "layouts/nav.php"; ?>

<!-- Modal para Crear y Editar Proveedor -->
<div class="modal fade" id="crearproveedor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Crear proveedor</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /.card-header -->

                <form id="form-crear">
                    <div class="card-body">
                        <!-- Mensajes de Alerta -->
                        <div class="alert alert-success text-center" id="add-prov" style="display:none;">
                            <span><i class="fas fa-thumbs-up m-1"></i> Proveedor registrado con exito</span>
                        </div>

                        <div class="alert alert-danger text-center" id="noadd-prov" style="display:none;">
                            <span><i class="fas fa-exclamation-triangle m-1"></i> <b>El proveedor ya existe</b></span>
                        </div>

                        <div class="alert alert-success text-center" id="edit-prove" style="display:none;">
                            <span><i class="fas fa-thumbs-up m-1"></i> Proveedor editado con exito</span>
                        </div>
                        <!-- Fin Mensajes de Alerta -->

                        <!-- Nombre(s) -->
                        <div class="form-group">
                            <label for="nombre">Nombre(s)</label>
                            <input id="nombre" type="text" class="form-control" placeholder="Ingrese nombre(s)" required>
                        </div>

                        <!-- Teléfono -->
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input id="telefono" type="number" class="form-control" placeholder="Ingrese teléfono" required>
                        </div>
                        
                        <!-- Correo Electrónico -->
                        <div class="form-group">
                            <label for="correo">Correo Electrónico</label>
                            <input id="correo" type="email" class="form-control" placeholder="Ingrese su correo electrónico">
                        </div>

                        <!-- Dirección -->
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input id="direccion" type="text" class="form-control" placeholder="Ingrese dirección" required>
                        </div>

                        <input type="text" id="id_edit_prov">
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

<!-- Modal para cambiar Logo de Proveedor -->
<div class="modal fade" id="cambiologo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar Logo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- form-data permite el envio de datos por medio del atributo name de cada elemento -->
            <form id="form-logo" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="text-center">
                        <img id="logoactual" src="" alt="Imágen de Avatar del Usuario" class="profile-user-img img-fluid img-circle">
                    </div>
                    <div class="text-center">
                        <b id="nombre_logo"></b>
                    </div>

                    <!-- Mensajes de Alerta -->
                    <div class="alert alert-success text-center" id="edit-prov" style="display:none;">
                        <span><i class="fas fa-thumbs-up m-1"></i> Logo cambiado con exito</span>
                    </div>

                    <div class="alert alert-danger text-center" id="noedit-prov" style="display:none;">
                        <span><i class="fas fa-exclamation-triangle m-1"></i> <b>Formato de imágen no permitido</b></span>
                    </div>
                    <!-- Fin Mensajes de Alerta -->

                    <div class="input-group ml-5 mb-3 mt-3">
                        <input type="file" name="photo" class="input-group ml-5 ">
                        <input type="hidden" name="funcion" id="funcion">
                        <input type="hidden" name="id_logo_prov" id="id_logo_prov">
                        <input type="hidden" name="avatar" id="avatar">
                    </div><!-- /.input-group -->
                </div><!-- /.modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión proveedores 
                        <button type="button" data-toggle="modal" data-target="#crearproveedor" class="btn bg-gradient-info ml-2">
                            Crear proveedor
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Home</a></li>
                        <li class="breadcrumb-item active">Gestión proveedor</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content-header -->

    <section>
        <div class="container-fluid">
            <card class="card card-info">
                <div class="card-header">
                    <h3 class="card-title mb-2">Buscar proveedor</h3>
                    <div class="input-group">
                        <input id="buscar_proveedor" type="text" class="form-control float-left" placeholder="Ingrese nombre de proveedor...">
                        <div class="input-group-append">
                            <button class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div> 
                </div><!-- /.card-header -->

                <div class="card-body">
                    <div id="proveedores" class="row d-flex align-items-stretch">

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

<script src="../js/Proveedor.js"></script>