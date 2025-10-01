<?php 

    include_once "../modelo/Tipo.php";

    $tipo = new Tipo();

    if ($_POST["funcion"] == "crear") {
        $nombre = $_POST["nombre_tipo"];
        $tipo -> crear($nombre);
    }

    if ($_POST["funcion"] == "editar") {
        $nombre = $_POST["nombre_tipo"];
        $id_editado = $_POST["id_editado"];
        $tipo -> editar($id_editado, $nombre);
    }

    if ($_POST["funcion"] == "buscar") { 
        $tipo -> buscar();
        $json = array();
        foreach ($tipo -> objetos as $objeto) {
            $json[] = array(
                "id" => $objeto -> id_tip_prod,
                "nombre" => $objeto -> nombre,
            );
        }
        $jsonstring = json_encode($json);
        echo $jsonstring;
    }

    if ($_POST["funcion"] == "borrar") {
        $id = $_POST["id"];
        $tipo -> borrar($id);
    }

    /* Petición que se realiza desde Producto.js para rellenar un select con nombres de tipo de producto */
    if ($_POST["funcion"] == "rellenar_tipos") {

        $tipo -> rellenar_tipos();

        $json = array();

        foreach ($tipo -> objetos as $objeto) {
            $json[] = array(
                "id" => $objeto -> id_tip_prod,
                "nombre" => $objeto -> nombre
            );
        }

        $jsonstring = json_encode($json);

        echo $jsonstring;
        
    }