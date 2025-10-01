<?php 

    include_once "Conexion.php";

    class Tipo {

        var $objetos;

        public function __construct() {
            $db = new Conexion();
            $this -> acceso = $db -> pdo;
        }

        function crear($nombre) {
            /* Verifico primero si el tipo de producto ya existe en la Base de Datos */
            $sql = "SELECT id_tip_prod 
                    FROM tipo_producto 
                    WHERE nombre = :nombre";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":nombre" => $nombre));
            $this -> objetos = $query -> fetchAll();

            /* Si no existe respuesta es porque el nombre de Tipo Producto ya existe, caso contrario agregamos un Tipo Producto */
            if (!empty($this -> objetos)) {
                echo "noadd";
            } else {
                $sql = "INSERT INTO tipo_producto (nombre)
                    VALUES (:nombre)";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute(array(":nombre" => $nombre));
                echo "add";
            }
        }

        function buscar() {
            if (!empty($_POST["consulta"])) {
                $consulta = $_POST["consulta"];
                $sql = "SELECT *
                        FROM tipo_producto
                        WHERE nombre LIKE :consulta";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute(array(":consulta" => "%$consulta%"));
                $this -> objetos = $query -> fetchAll();
                return $this -> objetos;
            } else {
                $sql = "SELECT *
                        FROM tipo_producto
                        WHERE nombre NOT LIKE '' 
                        ORDER BY id_tip_prod
                        LIMIT 25";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute();
                $this -> objetos = $query -> fetchAll();
                return $this -> objetos;
            }
        }

        function borrar($id) {
            $sql = "DELETE FROM tipo_producto 
                    WHERE id_tip_prod = :id";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":id" => $id));

            /* Verifica si se elimino el registro */
            if (!empty($query -> execute(array(":id" => $id)))) {
                echo "borrado";
            } else {
                echo "noborrado";
            }
        }

        function editar($id_editado, $nombre) {
            $sql = "UPDATE tipo_producto
                    SET nombre = :nombre 
                    WHERE id_tip_prod = :id";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":id" => $id_editado, ":nombre" => $nombre));
            echo "edit";
        }

        /* Función que retorna todos los nombres de tipo de producto de la tabla tipo_producto. */
        function rellenar_tipos() {

            $sql = "SELECT *
                    FROM tipo_producto
                    ORDER BY nombre ASC";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute();

            $this -> objetos = $query -> fetchAll();

            return $this -> objetos;
            
        }

    }