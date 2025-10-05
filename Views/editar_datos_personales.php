<?php 
    session_start();
    if ($_SESSION["us_tipo"] == 1 || $_SESSION["us_tipo"] == 3 || $_SESSION["us_tipo"] == 2) {

        include_once "layouts/header.php";
?>

<title>Adm | Editar Datos</title>
        
<?php include_once "layouts/nav.php"; ?>

<!-- Modal para cambiar contraseña de Usuario -->
<div class="animate__animated animate__bounceInDown modal fade" id="cambiocontra" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form-pass">
                <div class="modal-body">

                    <!--  Avatar Usuario-->
                    <div class="text-center">
                        <img id="avatar3" src="../img/avatar.png" alt="Imágen de Avatar del Usuario" class="profile-user-img img-fluid img-circle">
                    </div>

                    <!-- Nombre Usuario Logueado -->
                    <div class="text-center">
                        <b>
                            <?php 
                                echo $_SESSION["nombre_us"];
                            ?>
                        </b>
                    </div>

                    <!-- Mensajes de Alerta -->
                    <div id="update" class="alert alert-success text-center" style="display:none;">
                        <span><i class="fas fa-thumbs-up m-1"></i> Contraseña cambiada con exito</span>
                    </div>

                    <div id="noupdate" class="alert alert-danger text-center" style="display:none;">
                        <span><i class="fas fa-exclamation-triangle m-1"></i> <b>La contraseña actual no es correcta</b></span>
                    </div>
                    <!-- Fin Mensajes de Alerta -->

                    <!-- Contraseña Actual -->
                    <div class="input-group mb-3 mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-unlock-alt"></i>
                            </span>
                        </div>
                        <input id="oldpass" type="password" class="form-control" placeholder="Ingrese contraseña actual">
                    </div><!-- /.input-group -->

                    <!-- Nueva Contraseña -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                        </div>
                        <input id="newpass" type="text" class="form-control" placeholder="Ingrese nueva contraseña">
                    </div><!-- /.input-group -->
                    
                </div><!-- /.modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-info">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- /.modal -->

<!-- Modal para cambiar avatar de Usuario -->
<div class="animate__animated animate__bounceInDown modal fade" id="cambiophoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cambiar avatar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div><!-- /.modal-header -->

            <!-- form-data permite el envio de datos por medio del atributo name de cada elemento -->
            <form id="form-photo" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="text-center">
                        <img id="avatar1" src="../img/avatar.png" alt="Imágen de Avatar del Usuario" class="profile-user-img img-fluid img-circle">
                    </div>
                    <div class="text-center">
                        <b>
                            <?php 
                                echo $_SESSION["nombre_us"];
                            ?>
                        </b>
                    </div>
                    <!-- Mensajes de Alerta -->
                    <div class="alert alert-success text-center" id="edit" style="display:none;">
                        <span><i class="fas fa-thumbs-up m-1"></i> Avatar cambiado con exito</span>
                    </div>

                    <div class="alert alert-danger text-center" id="noedit" style="display:none;">
                        <span><i class="fas fa-exclamation-triangle m-1"></i> <b>Formato de imágen no permitido</b></span>
                    </div>
                    <!-- Fin Mensajes de Alerta -->
    
                    <div class="input-group ml-5 mb-3 mt-3">
                        <input type="file" name="photo" class="input-group ml-5 ">
                        <input type="hidden" name="funcion" value="cambiar_foto">
                    </div><!-- /.input-group -->
                </div><!-- /.modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                </div><!-- /.modal-footer -->
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
                    <h1>Datos personales</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="../vista/adm_catalogo.php">Inicio</a></li>
                        <li class="breadcrumb-item active">Datos personales</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section><!-- /.content-header -->

    <section>
        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    <!-- Columna Isquierda -->
                    <div class="col-md-3">

                        <!-- Card Superior Isquierdo -->
                        <div class="card card-success card-outline">
                            <div class="card-body box-profile">
                                <!-- Avatar del Usuario -->
                                <div class="text-center">
                                    <img id="avatar2" src="../img/avatar.png" class="profile-user-img img-fluid img-circle" alt="Imágen de Avatar">
                                </div>
                                <div class="text-center">
                                    <button data-toggle="modal" data-target="#cambiophoto" type="button" class="btn btn-info btn-sm mt-2">Cambiar avatar</button>
                                </div>
                                
                                <!-- Obtiene el campo id_usuario de la sesión -->
                                <input type="hidden" id="id_usuario" value="<?php echo $_SESSION["usuario"]; ?>">

                                <h3 id="nombre_us" class="profile-username text-center text-success">Nombre</h3>
                                
                                <p id="apellidos_us" class="text-muted text-center">Apellidos</p>
                                
                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b style="color: #0B7300;">Edad</b><a id="edad" class="float-right">12</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color: #0B7300;">DNI</b><a id="dni_us" class="float-right">12</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b style="color: #0B7300;">Tipo Usuario</b>
                                        <span id="us_tipo" class="float-right">Administrador</span>
                                    </li>

                                    <button data-target="#cambiocontra" data-toggle="modal" type="button" class="btn btn-block btn-outline-warning btn-sm mt-4">
                                        Cambiar Contraseña
                                    </button>

                                </ul>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->

                        <!-- Card Inferior Isquierdo -->
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Sobre mí</h3>
                            </div>

                            <div class="card-body">
                                <strong style="color: #0B7300;">
                                    <i class="fas fa-phone mr-1"></i>Teléfono
                                </strong>
                                <p id="telefono_us" class="text-muted">2346753</p>

                                <strong style="color: #0B7300;">
                                    <i class="fas fa-map-marker-alt mr-1"></i>Residencia
                                </strong>
                                <p id="residencia_us" class="text-muted">Zona San Pedro</p>

                                <strong style="color: #0B7300;">
                                    <i class="fas fa-at mr-1"></i>Correo Electrónico
                                </strong>
                                <p id="correo_us" class="text-muted">juan_carlos@gmail.com</p>

                                <strong style="color: #0B7300;">
                                    <i class="fas fa-smile-wink mr-1"></i>Género
                                </strong>
                                <p id="sexo_us" class="text-muted">Masculino</p>

                                <strong style="color: #0B7300;">
                                    <i class="fas fa-pencil mr-1"></i>Información Adicional
                                </strong>
                                <p id="adicional_us" class="text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, eligendi.</p>

                                <button class="edit btn btn-block bg-gradient-danger">Editar</button>
                            </div><!-- /.card-body -->

                            <div class="card-footer">
                                <p class="text-muted">Clic en botón si desea editar</p>
                            </div>
                        </div><!-- /.card -->

                    </div><!-- /.col-md-3 -->

                    <!-- Columna Derecha -->
                    <div class="col-md-9">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Editar datos personales</h3>
                            </div>

                            <div class="card-body">

                                <!-- Mensajes de Alerta -->
                                <div id="editado" class="alert alert-success text-center" style="display: none;">
                                    <span><i class="fas fa-thumbs-up m-1"></i> Editado con éxito</span>
                                </div>

                                <div id="noeditado" class="alert alert-danger text-center" style="display: none;">
                                    <span><i class="fas fa-exclamation-triangle m-1"></i> <b>Edición Deshabilitada</b></span>
                                </div>
                                <!-- Fin Mensajes de Alerta -->

                                <!-- Manipulación mediante JavaScript -->
                                <form id="form-usuario" class="form-horizontal">
                                    <!-- Teléfono -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="telefono" >Teléfono</label>
                                        <div class="col-sm-10">
                                            <input id="telefono" type="number" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Residencia -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="residencia" >Residencia</label>
                                        <div class="col-sm-10">
                                            <input id="residencia" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Correo Electrónico -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="correo" >Correo</label>
                                        <div class="col-sm-10">
                                            <input id="correo" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Género -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="sexo" >Género</label>
                                        <div class="col-sm-10">
                                            <input id="sexo" type="text" class="form-control">
                                        </div>
                                    </div>
                                    <!-- Información Adicional -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label" for="adicional" >Información Adicional</label>
                                        <div class="col-sm-10">
                                            <textarea id="adicional" class="form-control" rows="4"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10 float-right">
                                            <button class="btn btn-block btn-outline-success">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <p class="text-muted">Cuidado con ingresar datos erróneos.</p>
                            </div>
                        </div><!-- /.card -->
                    </div><!-- /.col-md-9 -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /.content -->
    </section>
</div><!-- /.content-wrapper -->


<?php 
        include_once "layouts/footer.php";

    } else { // Closed if
        header("Location: ../index.php");
    }  
?>

<script src="../js/Usuario.js"></script>