<?php 

    include_once "../modelo/Lote.php";

    $lote = new Lote();

    if ($_POST["funcion"] == "crear") {

        $id_producto = $_POST["id_producto"];

        $proveedor = $_POST["proveedor"];

        $stock = $_POST["stock"];

        $vencimiento = $_POST["vencimiento"];

        $lote -> crear($id_producto, $proveedor, $stock, $vencimiento);
        
    }

    if ($_POST["funcion"] == "buscar") {

        $lote -> buscar();

        $json = array();

        date_default_timezone_set('America/La_Paz');

        $fecha = date("Y-m-d h:i:s");

        $fecha_actual = new DateTime($fecha);

        foreach ($lote -> objetos as $objeto) {

            $vencimiento = new DateTime($objeto -> vencimiento);

            $diferencia = $vencimiento -> diff($fecha_actual);  /* Obtiene la diferencia entre la fecha actual y la fecha de vencimiento. */

            $mes = $diferencia -> m;    /* Diferencia en meses */

            $dia = $diferencia -> d;    /* Diferencia en dias */
            
            $verificado = $diferencia -> invert; /* Si el resultado de la diferencia es positiva da el valor de 1, caso contrario 0 (diferencia negativa) */
            
            /* Si verificado es igual a 0, significa que la diferencia es negativa o igual a 0,
               lo que siginifica que el producto ya vencio. */ 
            if ($verificado == 0) { 

                $estado = "danger";

                $mes = $mes * (-1);

                $dia = $dia * (-1);

            } else {

                if ($mes >= 3) {

                    $estado = "light";

                }

                if ($mes < 3) {

                    $estado = "warning";

                }
                
            }

            $json[] = array(
                "id" => $objeto -> id_lote,
                "stock" => $objeto -> stock,
                "vencimiento" => $objeto -> vencimiento,
                "concentracion" => $objeto -> concentracion,
                "adicional" => $objeto -> adicional,
                "nombre" => $objeto -> prod_nom,
                "laboratorio" => $objeto -> lab_nom,
                "tipo" => $objeto -> tip_nom,
                "presentacion" => $objeto -> pre_nom,
                "proveedor" => $objeto -> proveedor,
                "avatar" => "../img/prod/" . $objeto -> logo,
                "mes" => $mes,
                "dia" => $dia,
                "estado" => $estado,
            );

        }

        $jsonstring = json_encode($json);

        echo $jsonstring; 

    }

    if ($_POST["funcion"] == "editar") {

        $id_lote = $_POST["id"];

        $stock = $_POST["stock"];

        $lote -> editar($id_lote, $stock);

    }

    if ($_POST["funcion"] == "borrar") {

        $id = $_POST["id"];

        $lote -> borrar($id);
        
    }