<?php 
    session_start();
    if ($_SESSION["us_tipo"] == 1 || $_SESSION["us_tipo"] == 3) {

        include_once "layouts/header.php";
?>

    <title>Gestión Usuario</title>
        
<?php include_once "layouts/nav.php"; ?>

<!-- Modal para Crear Usuario -->
<div class="modal fade" id="crearusuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Crear usuario</h3>
                    <button data-dismiss="modal" aria-label="close" class="close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div><!-- /.card-header -->

                <form id="form-crear">
                    <div class="card-body">
                        <!-- Mensajes de Alerta -->
                        <div class="alert alert-success text-center" id="add" style="display:none;">
                            <span><i class="fas fa-thumbs-up m-1"></i> Usuario registrado con exito</span>
                        </div>

                        <div class="alert alert-danger text-center" id="noadd" style="display:none;">
                            <span><i class="fas fa-exclamation-triangle m-1"></i> <b>El DNI ya existe en otro Usuario</b></span>
                        </div>
                        <!-- Fin Mensajes de Alerta -->

                        <div class="form-group">
                            <label for="nombre">Nombre(s)</label>
                            <input id="nombre" type="text" class="form-control" placeholder="Ingrese nombre(s)" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido(s)</label>
                            <input id="apellido" type="text" class="form-control" placeholder="Ingrese apellido(s)" required>
                        </div>
                        <div class="form-group">
                            <label for="edad">Fecha de Nacimiento</label>
                            <input id="edad" type="date" class="form-control" placeholder="Ingrese fecha de nacimiento" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input id="dni" type="text" class="form-control" placeholder="Ingrese DNI" required>
                        </div>
                        <div class="form-group">
                            <label for="pass">Contraseña</label>
                            <input id="pass" type="password" class="form-control" placeholder="Ingrese contraseña" required>
                        </div>
                        
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

<!-- Modal para verificar contraseña de Usuario -->
<div class="modal fade" id="confirmar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmar acción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="text-center">
                    <img id="avatar3" src="../img/avatar.png" alt="Imágen de Avatar del Usuario" class="profile-user-img img-fluid img-circle">
                </div>
                <div class="text-center">
                    <b>
                        <?php 
                            echo $_SESSION["nombre_us"];
                        ?>
                    </b>
                </div>

                <span>Ingrese su contraseña para continuar</span>

                <!-- Mensajes de Alerta -->
                <div id="confirmado" class="alert alert-success text-center" style="display:none;">
                    <span><i class="fas fa-thumbs-up m-1"></i> Acción realizada con exito</span>
                </div>

                <div id="rechazado" class="alert alert-danger text-center" style="display:none;">
                    <span><i class="fas fa-exclamation-triangle m-1"></i> <b>La contraseña no es correcta</b></span>
                </div>
                <!-- Fin Mensajes de Alerta -->

                <form id="form-confirmar">
                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-unlock-alt"></i>
                            </span>
                        </div>
                        <input id="oldpass" type="password" class="form-control" placeholder="Ingrese contraseña actual">
                        <input type="hidden" id="id_user"><!-- Campo que recibira el id del usuario -->
                        <input type="hidden" id="funcion"><!-- Acción(Ascender/Descender) que se realizara con el usuario -->
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

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Gestión usuarios 
                        <button id="button-crear" type="button" data-toggle="modal" data-target="#crearusuario" class="btn bg-gradient-info ml-2">
                            Crear usuario
                        </button>
                    </h1>

                    <!-- Obtengo el tipo de usuario para trabajarlo en JS -->
                    <input type="hidden" id="tipo_usuario" value="<?php echo $_SESSION["us_tipo"]; ?>">

                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adm_catalogo.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Gestión usuario</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content-header -->

    <section>
        <div class="container-fluid">
            <card class="card card-info">
                <div class="card-header">
                    <h3 class="card-title mb-2">Buscar usuario</h3>
                    <div class="input-group">
                        <input id="buscar" type="text" class="form-control float-left" placeholder="Ingrese nombre de usuario...">
                        <div class="input-group-append">
                            <button class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div> 
                </div><!-- /.card-header -->

                <div class="card-body">
                    <div id="usuarios" class="row d-flex align-items-stretch">

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

<script src="../js/Gestion_usuario.js"></script>