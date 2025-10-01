<?php 
    session_start();

    if ($_SESSION["us_tipo"] == 1 || $_SESSION["us_tipo"] == 3) {

        include_once "layouts/header.php";
?>

    <title>Gestión Atributo</title>

    <?php include_once "layouts/nav.php"; ?>

    <!-- Modal para cambiar Logo de Laboratorio -->
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
                            <img id="logoactual" src="../img/avatar.png" alt="Imágen de Avatar del Usuario" class="profile-user-img img-fluid img-circle">
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

                        <div class="input-group ml-5 mb-3 mt-3">
                            <input type="file" name="photo" class="input-group ml-5 ">
                            <input type="hidden" name="funcion" id="funcion">
                            <input type="hidden" name="id_logo_lab" id="id_logo_lab">
                        </div><!-- /.input-group -->
                    </div><!-- /.modal-body -->

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->

    <!-- Modal para Crear y Editar Laboratorio -->
    <div class="modal fade" id="crearlaboratorio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear laboratorio</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- /.card-header -->

                    <form id="form-crear-laboratorio">
                        <div class="card-body">
                            <!-- Mensajes de Alerta -->
                            <div class="alert alert-success text-center" id="add-laboratorio" style="display:none;">
                                <span><i class="fas fa-thumbs-up m-1"></i> Laboratorio creado con exito</span>
                            </div>

                            <div class="alert alert-danger text-center" id="noadd-laboratorio" style="display:none;">
                                <span><i class="fas fa-exclamation-triangle m-1"></i> <b>El Laboratorio ya existe</b></span>
                            </div>

                            <div class="alert alert-success text-center" id="edit-lab" style="display:none;">
                                <span><i class="fas fa-thumbs-up m-1"></i> Laboratorio editado con exito</span>
                            </div>
                            <!-- Fin Mensajes de Alerta -->

                            
                            <div class="form-group">
                                <label for="nombre-laboratorio">Nombre</label>
                                <input id="nombre-laboratorio" type="text" class="form-control" placeholder="Ingrese nombre" required>
                                <input type="hidden" id="id_editar_lab">                       
                            </div>
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

    <!-- Modal para Crear y Editar Tipo -->
    <div class="modal fade" id="creartipo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear tipo</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- /.card-header -->

                    <form id="form-crear-tipo">
                        <div class="card-body">
                            <!-- Mensajes de Alerta -->
                            <div class="alert alert-success text-center" id="add-tipo" style="display:none;">
                                <span><i class="fas fa-thumbs-up m-1"></i> Tipo creado con exito</span>
                            </div>

                            <div class="alert alert-danger text-center" id="noadd-tipo" style="display:none;">
                                <span><i class="fas fa-exclamation-triangle m-1"></i> <b>El Tipo ya existe</b></span>
                            </div>

                            <div class="alert alert-success text-center" id="edit-tip" style="display:none;">
                                <span><i class="fas fa-thumbs-up m-1"></i> Tipo editado con exito</span>
                            </div>
                            <!-- Fin Mensajes de Alerta -->

                            <div class="form-group">
                                <label for="nombre-tipo">Nombre</label>
                                <input id="nombre-tipo" type="text" class="form-control" placeholder="Ingrese nombre" required>
                                <input type="hidden" id="id_editar_tip">
                            </div>
                        </div><!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Crear</button>
                            <button type="button" data-dismiss="modal" class="btn btn-outline-secondary float-right m-1">Cerrar</button>
                        </div><!-- /.card-footer -->
                    </form>
                </div><!-- /.card -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Modal para Crear y Editar Presentación -->
    <div class="modal fade" id="crearpresentacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear presentación</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div><!-- /.card-header -->

                    <form id="form-crear-presentacion">
                        <div class="card-body">
                            <!-- Mensajes de Alerta -->
                            <div class="alert alert-success text-center" id="add-pre" style="display:none;">
                                <span><i class="fas fa-thumbs-up m-1"></i> Presentación creada con exito</span>
                            </div>

                            <div class="alert alert-danger text-center" id="noadd-pre" style="display:none;">
                                <span><i class="fas fa-exclamation-triangle m-1"></i> <b>La Presentación ya existe</b></span>
                            </div>

                            <div class="alert alert-success text-center" id="edit-pre" style="display:none;">
                                <span><i class="fas fa-thumbs-up m-1"></i> Presentación editada con exito</span>
                            </div>
                            <!-- Fin Mensajes de Alerta -->

                            <div class="form-group">
                                <label for="nombre-presentacion">Nombre</label>
                                <input id="nombre-presentacion" type="text" class="form-control" placeholder="Ingrese nombre" required>
                                <input type="hidden" id="id_editar_pre"> 
                            </div>
                        </div><!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn bg-gradient-primary float-right m-1">Crear</button>
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
                    <div class="col-sm-6">
                        <h1>Gestión atributos</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adm_catalogo.php">Inicio</a></li>
                            <li class="breadcrumb-item active">Gestión atributo</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a href="#laboratorio" class="nav-link active" data-toggle="tab">
                                            Laboratorio
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#tipo" class="nav-link" data-toggle="tab">
                                            Tipo
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#presentacion" class="nav-link" data-toggle="tab">
                                            Presentación
                                        </a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->

                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <!-- Laboratorio -->
                                    <div class="tab-pane active" id="laboratorio">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <div class="card-title">Buscar Laboratorio 
                                                    <button type="button" data-toggle="modal" data-target="#crearlaboratorio" class="btn bg-gradient-primary btn-sm m-2">
                                                        Crear Laboratorio
                                                    </button>
                                                </div><!-- /.card-title -->
                                                <div class="input-group">
                                                    <input id="buscar-laboratorio" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div><!-- /.input-group -->
                                            </div><!-- /.card-header -->

                                            <div class="card-body p-0 table-responsive">
                                                <table class="table table-hover text-nowrap">
                                                    <thead class="table-info">
                                                        <tr>
                                                            <th>Laboratorio</th>
                                                            <th>Logo</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-active" id="laboratorios">

                                                    </tbody>
                                                </table>
                                            </div><!-- /.card-body -->

                                            <div class="card-footer">

                                            </div><!-- /.card-footer -->
                                        </div><!-- /.card -->
                                    </div><!-- /.tab -->

                                    <!-- Tipo -->
                                    <div class="tab-pane" id="tipo">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <div class="card-title">Buscar Tipo 
                                                    <button type="button" data-toggle="modal" data-target="#creartipo" class="btn bg-gradient-primary btn-sm m-2">
                                                        Crear Tipo
                                                    </button>
                                                </div><!-- /.card-title -->
                                                <div class="input-group">
                                                    <input id="buscar-tipo" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div><!-- /.input-group -->
                                            </div><!-- /.card-header -->

                                            <div class="card-body p-0 table-responsive">
                                                <table class="table table-hover text-nowrap">
                                                    <thead class="table-info">
                                                        <tr>
                                                            <th>Tipos</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-active" id="tipos">

                                                    </tbody>
                                                </table>
                                            </div><!-- /.card-body -->
                                            
                                            <div class="card-footer"></div>
                                        </div><!-- /.card -->
                                    </div><!-- /.tab -->

                                    <!-- Presentación -->
                                    <div class="tab-pane" id="presentacion">
                                        <div class="card card-success">
                                            <div class="card-header">
                                                <div class="card-title">Buscar Presentación 
                                                    <button type="button" data-toggle="modal" data-target="#crearpresentacion" class="btn bg-gradient-primary btn-sm m-2">
                                                        Crear Presentación
                                                    </button>
                                                </div><!-- /.card-title -->
                                                <div class="input-group">
                                                    <input id="buscar-presentacion" type="text" class="form-control float-left" placeholder="Ingrese nombre">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-default"><i class="fas fa-search"></i></button>
                                                    </div>
                                                </div><!-- /.input-group -->
                                            </div><!-- /.card-header -->

                                            <div class="card-body p-0 table-responsive">
                                                <table class="table table-hover text-nowrap">
                                                    <thead class="table-info">
                                                        <tr>
                                                            <th>Presentación</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="table-active" id="presentaciones">

                                                    </tbody>
                                                </table>
                                            </div><!-- /.card-body -->
                                            <div class="card-footer"></div>
                                        </div><!-- /.card -->
                                    </div><!-- /.tab -->
                                </div><!-- /.tab-content -->
                            </div><!-- /.card-body -->

                            <div class="card-footer">

                            </div><!-- /.card-footer -->
                        </div><!-- /.card -->
                    </div><!-- /.col-md-12 -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

<?php 
        include_once "layouts/footer.php";

    } else { // Closed if

        header("Location: ../index.php");
        
    }  
?>

<script src="../js/Laboratorio.js"></script>
<script src="../js/Tipo.js"></script>
<script src="../js/Presentacion.js"></script>
