<?php 

    include_once "Conexion.php";

    class Presentacion {

        var $objetos;

        public function __construct() {
            $db = new Conexion();
            $this -> acceso = $db -> pdo;
        }

        function crear($nombre) {
            /* Verifico primero si el nombre de la Presentación del producto ya existe en la Base de Datos */
            $sql = "SELECT id_presentacion
                    FROM presentacion 
                    WHERE nombre = :nombre";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":nombre" => $nombre));
            $this -> objetos = $query -> fetchAll();

            /* Si no existe respuesta es porque el nombre de la Presentación del producto ya existe, caso contrario agregamos una Presentación */
            if (!empty($this -> objetos)) {
                echo "noadd";
            } else {
                $sql = "INSERT INTO presentacion (nombre)
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
                        FROM presentacion
                        WHERE nombre LIKE :consulta";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute(array(":consulta" => "%$consulta%"));
                $this -> objetos = $query -> fetchAll();
                return $this -> objetos;
            } else {
                $sql = "SELECT *
                        FROM presentacion
                        WHERE nombre NOT LIKE '' 
                        ORDER BY id_presentacion
                        LIMIT 25";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute();
                $this -> objetos = $query -> fetchAll();
                return $this -> objetos;
            }
        }

        function borrar($id) {
            $sql = "DELETE FROM presentacion 
                    WHERE id_presentacion = :id";
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
            $sql = "UPDATE presentacion
                    SET nombre = :nombre 
                    WHERE id_presentacion = :id";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":id" => $id_editado, ":nombre" => $nombre));
            echo "edit";
        }

        /* Función que retorna todos los nombres de presentación de la tabla presentación. */
        function rellenar_presentaciones() {

            $sql = "SELECT *
                    FROM presentacion
                    ORDER BY nombre ASC";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute();

            $this -> objetos = $query -> fetchAll();

            return $this -> objetos;

        }

    }