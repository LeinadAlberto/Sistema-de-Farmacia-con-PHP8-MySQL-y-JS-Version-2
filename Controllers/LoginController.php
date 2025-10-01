<?php 

    include "../modelo/Usuario.php";

    session_start();

    $user = $_POST["user"];

    $pass = $_POST["pass"];

    $usuario = new Usuario();

    /* Verificamos si ya existe una sesión */
    if (!empty($_SESSION["us_tipo"])) {

        switch ($_SESSION["us_tipo"]) { 
            /* 1: Cuando el usuario es Administrador */
            case 1:
                header("Location: ../vista/adm_catalogo.php");
            break; 

            /* 2: Cuando el usuario es Técnico */
            case 2:
                header("Location: ../vista/adm_catalogo.php");
            break;

            /* 3: Cuando el usuario es de tipo Root */
            case 3:
                header("Location: ../vista/adm_catalogo.php");
            break;
        }
        
    } else {

        /* Si no existe sesión, verificamos si las credenciales son correctas. */
        
        /* Si ingresa correctamente creamos variables de sesión */
        if (!empty($usuario -> loguearse($user, $pass) == "logueado")) {
            
            $usuario -> obtener_dato_logueo($user);

            foreach ($usuario -> objetos as $objeto) { 

                /* print_r($objeto); */

                /* Creando Variables de Sesión */
                $_SESSION["usuario"] = $objeto -> id_usuario;

                $_SESSION["nombre_us"] = $objeto -> nombre_us;

                $_SESSION["us_tipo"] = $objeto -> us_tipo;

            }

            switch ($_SESSION["us_tipo"]) { 
                /* 1: Cuando el usuario es Administrador */
                case 1:
                    header("Location: ../vista/adm_catalogo.php");
                break; 

                /* 2: Cuando el usuario es Técnico */
                case 2:
                    header("Location: ../vista/adm_catalogo.php");
                break;

                /* 3: Cuando el usuario es de tipo Root */
                case 3:
                    header("Location: ../vista/adm_catalogo.php");
                break;
            }

        } else {
            /* Si al loguearse las credenciales no son las correctas, se redirecciona al mismo login */
            header("Location: ../index.php");
        }  
    }
    
?> 