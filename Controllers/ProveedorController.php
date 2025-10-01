<?php 

    include_once "../modelo/Proveedor.php";

    $proveedor = new Proveedor();

    if($_POST["funcion"] == "crear") {

        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $correo = $_POST["correo"];
        $direccion = $_POST["direccion"];
        $avatar = "prov_default.png";

        $proveedor -> crear($nombre, $telefono, $correo, $direccion, $avatar);

    }

    if($_POST["funcion"] == "editar") {

        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $telefono = $_POST["telefono"];
        $correo = $_POST["correo"];
        $direccion = $_POST["direccion"];

        $proveedor -> editar($id, $nombre, $telefono, $correo, $direccion);
        
    }

    if($_POST["funcion"] == "buscar") {

        $proveedor -> buscar();

        $json = array();

        foreach ($proveedor -> objetos as $objeto) {

            $json[] = array(
                "id" => $objeto -> id_proveedor,
                "nombre" => $objeto -> nombre,
                "telefono" => $objeto -> telefono,
                "correo" => $objeto -> correo,
                "direccion" => $objeto -> direccion,
                "avatar" => "../img/prov/" . $objeto -> avatar
            );

        }

        $jsonstring = json_encode($json);

        echo $jsonstring;

    }

    if ($_POST["funcion"] == "cambiar_logo") {

        $id = $_POST["id_logo_prov"];

        $avatar = $_POST["avatar"]; /* Obtenemos la ruta del avatar actual del Proveedor */

        /* Valida que el archivo solo sea una imagen de tipo jpeg, png o gif. */
        if (($_FILES["photo"]["type"] == "image/jpeg") || ($_FILES["photo"]["type"] == "image/png") || ($_FILES["photo"]["type"] == "image/gif")) {
            
            $nombre = uniqid() . "-" . $_FILES["photo"]["name"]; /* Obtiene el nombre de la imágen y le concatena un valor unico. */
            
            $ruta = "../img/prov/" . $nombre;
            
            move_uploaded_file($_FILES["photo"]["tmp_name"], $ruta); /* Mueve la foto en la ruta definida para ser almacenada */
            
            /* Envia al modelo para cambiar avatar */
            $proveedor -> cambiar_logo($id, $nombre);
        
            if ($avatar != "../img/prov/prov_default.png") { /* La condición evita que se borre la imágen por defecto */
                
                /* Elimina el antiguo avatar */
                unlink($avatar); // Borra un fichero, como parametro la ruta del fichero.

            }
            
            $json = array();

            $json[] = array(
                "ruta" => $ruta, /* Ruta de la nueva imágen para ser enviada a la vista */
                "alert" => "edit" /* Mensaje de alerta para ser enviada a la vista */
            );

            $jsonstring = json_encode($json[0]);

            echo $jsonstring;

        } else {

            $json = array();

            $json[] = array(
                "alert" => "noedit"
            );

            $jsonstring = json_encode($json[0]);

            echo $jsonstring;

        }   

    }

    if ($_POST["funcion"] == "borrar") {

        $id = $_POST["id"];

        $proveedor -> borrar($id);

    }

    /* Petición realizada desde producto.js para mostrar en el  modal crearlote las lista
    de proveedores en un select2. */
    if ($_POST["funcion"] == "rellenar_proveedores") {

        $proveedor -> rellenar_proveedores();

        $json = array();

        foreach ($proveedor -> objetos as $objeto) {

            $json[] = array(
                "id" => $objeto -> id_proveedor,
                "nombre" => $objeto -> nombre
            );

        }

        $jsonstring = json_encode($json);

        echo $jsonstring;
        
    }