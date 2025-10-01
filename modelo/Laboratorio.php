<?php 

    include_once "Conexion.php";

    class Laboratorio {

        var $objetos;

        public function __construct() {
            $db = new Conexion();
            $this -> acceso = $db -> pdo;
        }

        function crear($nombre, $avatar) {
            /* Verifico primero si el nombre del laboratorio ya existe en la Base de Datos */
            $sql = "SELECT id_laboratorio 
                    FROM laboratorio 
                    WHERE nombre = :nombre";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":nombre" => $nombre));
            $this -> objetos = $query -> fetchAll();

            /* Si no existe respuesta es porque el nombre del laboratorio ya existe, caso contrario agregamos un laboratorio */
            if (!empty($this -> objetos)) {
                echo "noadd";
            } else {
                $sql = "INSERT INTO laboratorio (nombre, avatar)
                    VALUES (:nombre, :avatar)";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute(array(":nombre" => $nombre, ":avatar" => $avatar));
                echo "add";
            }
        }

        function buscar() {
            if (!empty($_POST["consulta"])) {
                $consulta = $_POST["consulta"];
                $sql = "SELECT *
                        FROM laboratorio
                        WHERE nombre LIKE :consulta";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute(array(":consulta" => "%$consulta%"));
                $this -> objetos = $query -> fetchAll();
                return $this -> objetos;
            } else {
                $sql = "SELECT *
                        FROM laboratorio
                        WHERE nombre NOT LIKE '' 
                        ORDER BY id_laboratorio
                        LIMIT 25";
                $query = $this -> acceso -> prepare($sql);
                $query -> execute();
                $this -> objetos = $query -> fetchAll();
                return $this -> objetos;
            }
        }

        function cambiar_logo($id, $nombre) {
            /* Obtenemos el avatar actual */
            $sql = "SELECT avatar 
                    FROM laboratorio 
                    WHERE id_laboratorio = :id";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":id" => $id));
            $this -> objetos = $query -> fetchAll();

            /* Remplazamos el nuevo avatar */
            $sql = "UPDATE laboratorio 
                    SET avatar = :nombre 
                    WHERE id_laboratorio = :id";
            $query = $this -> acceso -> prepare($sql);
            $query -> execute(array(":id" => $id, ":nombre" => $nombre));

            return $this -> objetos; /* Retornamos al controlador el avatar antiguo */
        } 

        function borrar($id) {

            $sql = "DELETE FROM laboratorio 
                    WHERE id_laboratorio = :id";

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

            $sql = "UPDATE laboratorio
                    SET nombre = :nombre 
                    WHERE id_laboratorio = :id";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute(array(":id" => $id_editado, ":nombre" => $nombre));

            echo "edit";
            
        }

        /* Función que retorna todos los nombres de laboratorio de la tabla laboratorio. */
        function rellenar_laboratorios() {

            $sql = "SELECT *
                    FROM laboratorio
                    ORDER BY nombre ASC"; /* Ordena por nombre y de forma ascendente */

            $query = $this -> acceso -> prepare($sql);

            $query -> execute();

            $this -> objetos = $query -> fetchAll();

            return $this -> objetos;
            
        }
    }