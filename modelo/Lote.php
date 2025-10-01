<?php 

    include_once "Conexion.php";

    class Lote {

        var $objetos;

        public function __construct() {

            $db = new Conexion();

            $this -> acceso = $db -> pdo;

        }

        function crear($id_producto, $proveedor, $stock, $vencimiento) {

            $sql = "INSERT INTO lote (stock, vencimiento, lote_id_prod, lote_id_prov)
                        VALUES (:stock, :vencimiento, :id_producto, :id_proveedor)";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute(array(":stock" => $stock, 
                                    ":vencimiento" => $vencimiento, 
                                    ":id_producto" => $id_producto, 
                                    ":id_proveedor" => $proveedor, 
                                ));

            echo "add";
            
        }

        function buscar() {

            if (!empty($_POST["consulta"])) {

                $consulta = $_POST["consulta"];

                $sql = "SELECT 
                            id_lote,                                /* lote */
                            stock,                                  /* lote */
                            vencimiento,                            /* lote */
                            concentracion,                          /* producto */
                            adicional,                              /* producto */
                            producto.nombre AS prod_nom,            /* producto */
                            laboratorio.nombre AS lab_nom,          /* laboratorio */
                            tipo_producto.nombre AS tip_nom,        /* tipo_producto */
                            presentacion.nombre AS pre_nom,         /* presentacion */
                            proveedor.nombre AS proveedor,          /* proveedor */
                            producto.avatar AS logo                 /* producto */
                            FROM lote
                            JOIN proveedor ON lote_id_prov = id_proveedor
                            JOIN producto ON lote_id_prod = id_producto
                            JOIN laboratorio ON prod_lab = id_laboratorio
                            JOIN tipo_producto ON prod_tip_prod = id_tip_prod
                            JOIN presentacion ON prod_present = id_presentacion
                            AND producto.nombre LIKE :consulta 
                            ORDER BY producto.nombre 
                            LIMIT 25";

                $query = $this -> acceso -> prepare($sql);

                $query -> execute(array(":consulta" => "%$consulta%"));

                $this -> objetos = $query -> fetchAll();

                return $this -> objetos;

            } else {
                /*  Esta consulta SQL selecciona información de varias tablas 
                    y aplica una condición para excluir registros donde el valor 
                    de producto.nombre es una cadena vacía. Luego, ordena los 
                    resultados y limita la salida a 25 filas. */
                $sql = "SELECT 
                            id_lote, 
                            stock, 
                            vencimiento, 
                            concentracion, 
                            adicional,
                            producto.nombre AS prod_nom,
                            laboratorio.nombre AS lab_nom,
                            tipo_producto.nombre AS tip_nom,
                            presentacion.nombre AS pre_nom,
                            proveedor.nombre AS proveedor,
                            producto.avatar AS logo 
                            FROM lote
                            JOIN proveedor ON lote_id_prov = id_proveedor
                            JOIN producto ON lote_id_prod = id_producto
                            JOIN laboratorio ON prod_lab = id_laboratorio
                            JOIN tipo_producto ON prod_tip_prod = id_tip_prod
                            JOIN presentacion ON prod_present = id_presentacion
                            AND producto.nombre NOT LIKE '' /* Seleccionará registros donde el valor de la columna producto.nombre no sea una cadena vacía (''). */
                            ORDER BY producto.nombre 
                            LIMIT 100";

                $query = $this -> acceso -> prepare($sql);

                $query -> execute();

                $this -> objetos = $query -> fetchAll();

                return $this -> objetos;

            }

        }

        function editar($id, $stock) {

            $sql = "UPDATE lote 
                    SET stock = :stock
                    WHERE id_lote = :id";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute(array(":stock" => $stock, ":id" => $id));

            echo "edit";

        }

        function borrar($id) {

            $sql = "DELETE FROM lote 
                    WHERE id_lote = :id";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute(array(":id" => $id));

            if (!empty($query -> execute(array(":id" => $id)))) {

                echo "borrado";

            } else {

                echo "noborrado";

            }
            
        }

    }