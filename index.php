<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="#" type="image/x-icon">
        <title>Login | Farmacia</title>

        <!-- Google Fonts - Poppins 700 -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome Free 5.15.4 - CSS  -->
        <link rel="stylesheet" href="/farmaciav2/Util/css/css/all.min.css"> 

        <!-- Custom CSS -->
        <link rel="stylesheet" href="/farmaciav2/Util/css/login.css"> 
    </head>

    <body>

        <img class="wave" src="/farmaciav2/Util/img/login/wave.png" alt="Imágen de olas">

        <div class="contenedor">
            <div class="img">
                <img src="/farmaciav2/Util/img/login/bg.svg" alt="Imágen de dos doctores">
            </div>

            <div class="contenido-login">

                <form id="form-login">

                    <img src="/farmaciav2/Util/img/logo.png" alt="Imágen de un logo">

                    <h2>Farmacia</h2>

                    <!-- DNI -->
                    <div class="input-div dni">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>

                        <div class="div">
                            <h5>DNI</h5>
                            <input class="input" type="text" name="dni" id="dni">
                        </div>
                    </div><!-- /.input-div -->

                    <!-- PASSWORD -->
                    <div class="input-div pass">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>

                        <div class="div">
                            <h5>Contraseña</h5>
                            <input class="input" type="password" name="pass" id="pass">
                        </div>    
                    </div><!-- /.input-div -->
                    
                    <a class="recuperar-password" href="vista/recuperar.php">Recuperar Contraseña</a>

                    <a href="">Created LokyWebDev</a>

                    <input type="submit" class="btn" value="Iniciar Sesión">

                </form>
                
            </div><!-- /.contenido-login -->

        </div><!-- /.contenedor -->
    
    </body>

    <!-- jQuery -->
    <script src="/farmaciav2/Util/js/jquery.min.js"></script>
    
    <!-- Custom JS -->
    <script src="/farmaciav2/Util/js/login.js"></script>
    <script src="/farmaciav2/index.js"></script>

</html>

