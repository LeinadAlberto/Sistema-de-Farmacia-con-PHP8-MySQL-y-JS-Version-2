<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Recuperar Contraseña</title>
        <!-- Favicon -->
        <link rel="icon" href="../img/logo.png" type="image/png">
        <!-- Tell the browser to be responsive to screen width -->
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="../css/css/all.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../css/adminlte.min.css">
        <!-- SweetAlert2 - CSS -->
        <link rel="stylesheet" href="../css/sweetalert2.css">
        <!-- Google Font: Source Sans Pro -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

        <style>
            .form-control:focus {
                color: #495057;
                background-color: #fff;
                border-color: #3D9898;
                    border-right-color: rgb(176, 24, 59);
                outline: 0;
                box-shadow: inset 0 0 0 transparent,none;
            }

            .login-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text, .register-card-body .input-group .form-control:focus ~ .input-group-append .input-group-text {
                border-color: #3D9898;
            }
        </style>
    </head>

    <body class="hold-transition login-page">

        <div class="login-box">
            <div class="login-logo">
                <a href="../index.php" style="color: #3D9898;"><b>Farmacia</b></a>
            </div><!-- /.login-logo -->

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">¿Olvidaste tu contraseña? <br>Aquí puedes recuperar fácilmente una nueva contraseña.</p>

                    <span id="aviso1" class="text-success text-bold"></span>
                    
                    <span id="aviso" class="text-danger text-bold mb-2 d-block"></span>

                    <form id="form-recuperar" action="" method="post">
                        <!-- DNI -->
                        <div class="input-group mb-3">
                            <input id="dni-recuperar" type="text" class="form-control" placeholder="DNI">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-address-card" style="color: #3D9898;"></span>
                                </div>
                            </div>
                        </div>
                        <!-- Correo Electrónico -->
                        <div class="input-group mb-3">
                            <input id="email-recuperar" type="email" class="form-control" placeholder="Correo Electrónico">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="fas fa-envelope" style="color: #3D9898;"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block bg-info" style="border-color: #3D9898;">Pedir nueva contraseña</button>
                        </div>
                        <!-- /.col -->
                        </div>
                    </form>

                    <p class="login-box-msg mt-3">Se le enviara un código a su correo electrónico.</p>

                    <p class="mt-3 mb-1">
                        <a href="../index.php" class="text-info">Iniciar Sesión</a>
                    </p>

                    <!-- <p class="mb-0">
                        <a href="register.html" class="text-center">Register a new membership</a>
                    </p> -->
                </div><!-- /.card-body -->
            </div><!-- /.card -->
        </div><!-- /.login-box -->

        <!-- jQuery -->
        <script src="../js/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="../js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="../js/adminlte.min.js"></script>
        <!-- Custom JS -->
        <script src="../js/recuperar.js"></script>
        <!-- SweetAlert2 - JS -->
        <script src="../js/sweetalert2.js"></script>

    </body>
</html>
