<?php 

include_once "Conexion.php";

class Producto {

    var $objetos;

    public function __construct() {
        $db = new Conexion();
        $this -> acceso = $db -> pdo;
    }

    /* Función que permite registrar un nuevo producto en la tabla producto de la Base de Datos. */
    function crear($nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion, $avatar) {
        /* Verifico primero si el nombre del producto ya existe en la Tabla producto de la BD. */
        $sql = "SELECT id_producto 
                FROM producto 
                WHERE nombre = :nombre 
                    AND concentracion = :concentracion 
                    AND adicional = :adicional 
                    AND prod_lab = :laboratorio 
                    AND prod_tip_prod = :tipo 
                    AND prod_present = :presentacion";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":nombre" => $nombre, 
                                ":concentracion" => $concentracion,
                                ":adicional" => $adicional,
                                ":laboratorio" => $laboratorio,
                                ":tipo" => $tipo,
                                ":presentacion" => $presentacion));   
                                        
        $this -> objetos = $query -> fetchAll();

        /* Si tenemos registros en la variable objetos es porque el producto ya existe asi que no se inserta a la Base de Datos, 
        caso contrario agregamos un producto a la Base de Datos. */
        if (!empty($this -> objetos)) {

            echo "noadd";

        } else {
            $sql = "INSERT INTO producto (nombre, concentracion, adicional, precio, prod_lab, prod_tip_prod, prod_present, avatar)
                    VALUES (:nombre, :concentracion, :adicional, :precio, :laboratorio, :tipo, :presentacion, :avatar)";
            
            $query = $this -> acceso -> prepare($sql);
            
            $query -> execute(array(":nombre" => $nombre, 
                                ":concentracion" => $concentracion,
                                ":adicional" => $adicional,
                                ":precio" => $precio,
                                ":laboratorio" => $laboratorio,
                                ":tipo" => $tipo,
                                ":presentacion" => $presentacion,
                                ":avatar" => $avatar
                            ));      

            echo "add";

        }
    }

    /* La función buscar() realiza una consulta a la base de datos para buscar productos. 
    Si se proporciona un término de búsqueda a través de un formulario POST, filtra los 
    productos según ese término. Si no se proporciona ningún término de búsqueda, devuelve 
    los primeros 25 productos ordenados por nombre. Los resultados se almacenan en $this->objetos 
    y se devuelven al final de la función. */
    function buscar() {

        if (!empty($_POST["consulta"])) {

            $consulta = $_POST["consulta"];

            $sql = "SELECT 
                        id_producto, 
                        producto.nombre AS nombre,
                        concentracion,
                        adicional,
                        precio,
                        laboratorio.nombre AS laboratorio,
                        tipo_producto.nombre AS tipo,
                        presentacion.nombre AS presentacion,
                        producto.avatar AS avatar,
                        prod_lab,
                        prod_tip_prod,
                        prod_present
                    FROM producto
                    JOIN laboratorio ON prod_lab = id_laboratorio
                    JOIN tipo_producto ON prod_tip_prod = id_tip_prod
                    JOIN presentacion ON prod_present = id_presentacion
                    AND producto.nombre LIKE :consulta
                    LIMIT 25";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute(array(":consulta" => "%$consulta%"));

            $this -> objetos = $query -> fetchAll();

            return $this -> objetos;

        } else {

            $sql = "SELECT 
                        id_producto, 
                        producto.nombre as nombre,
                        concentracion,
                        adicional,
                        precio,
                        laboratorio.nombre as laboratorio,
                        tipo_producto.nombre as tipo,
                        presentacion.nombre as presentacion,
                        producto.avatar as avatar,
                        prod_lab,
                        prod_tip_prod,
                        prod_present
                    FROM producto
                    JOIN laboratorio ON prod_lab = id_laboratorio
                    JOIN tipo_producto ON prod_tip_prod = id_tip_prod
                    JOIN presentacion ON prod_present = id_presentacion
                    AND producto.nombre NOT LIKE ''
                    ORDER BY producto.nombre
                    LIMIT 25";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute();

            $this -> objetos = $query -> fetchAll();

            return $this -> objetos;
            
        }
    }

    /* Función que permite cambiar la imágen de logo de un producto. */
    function cambiar_logo($id, $nombre) {

        $sql = "UPDATE producto 
                SET avatar = :nombre 
                WHERE id_producto = :id";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id" => $id, ":nombre" => $nombre));

    } 

    function editar($id, $nombre, $concentracion, $adicional, $precio, $laboratorio, $tipo, $presentacion) {

        /* Verifico primero si el nombre del producto ya existe en la Tabla producto de la BD. */
        $sql = "SELECT id_producto 
                FROM producto 
                WHERE id_producto != :id 
                    AND nombre = :nombre 
                    AND concentracion = :concentracion 
                    AND adicional = :adicional 
                    AND prod_lab = :laboratorio 
                    AND prod_tip_prod = :tipo 
                    AND prod_present = :presentacion";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id" => $id,
                                ":nombre" => $nombre, 
                                ":concentracion" => $concentracion,
                                ":adicional" => $adicional,
                                ":laboratorio" => $laboratorio,
                                ":tipo" => $tipo,
                                ":presentacion" => $presentacion));

        $this -> objetos = $query -> fetchAll();

        if (!empty($this -> objetos)) {

            echo "noedit";

        } else {

            $sql = "UPDATE producto 
                    SET nombre = :nombre, 
                        concentracion = :concentracion, 
                        adicional = :adicional, 
                        prod_lab = :laboratorio, 
                        prod_tip_prod = :tipo, 
                        prod_present = :presentacion,
                        precio = :precio
                    WHERE id_producto = :id
                        ";

            $query = $this -> acceso -> prepare($sql);

            $query -> execute(array(":nombre" => $nombre, 
                                ":concentracion" => $concentracion,
                                ":adicional" => $adicional,
                                ":laboratorio" => $laboratorio,
                                ":tipo" => $tipo,
                                ":presentacion" => $presentacion,
                                ":precio" => $precio,
                                ":id" => $id
                            ));

            echo "edit";
            
        }
    }
    
    function borrar($id) {

        $sql = "DELETE FROM producto 
                WHERE id_producto = :id";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id" => $id));

        /* Verifica si se elimino el producto */
        if (!empty($query -> execute(array(":id" => $id)))) {

            echo "borrado";

        } else {

            echo "noborrado";

        }
        
    }

    function obtener_stock($id) {

        $sql = "SELECT SUM(stock) as total
                FROM lote
                WHERE lote_id_prod = :id";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id" => $id));

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;
        
    }

    /* Obtiene los datos de un producto mediante su id */
    function buscar_id($id) {
        
        $sql = "SELECT 
                    id_producto, 
                    producto.nombre as nombre,
                    concentracion,
                    adicional,
                    precio,
                    laboratorio.nombre as laboratorio,
                    tipo_producto.nombre as tipo,
                    presentacion.nombre as presentacion,
                    producto.avatar as avatar,
                    prod_lab,
                    prod_tip_prod,
                    prod_present
                FROM producto
                JOIN laboratorio ON prod_lab = id_laboratorio
                JOIN tipo_producto ON prod_tip_prod = id_tip_prod
                JOIN presentacion ON prod_present = id_presentacion
                WHERE id_producto = :id";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id" => $id));

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }
    
    /* Método que trabaja con la parte de Reporte Productos */
    function reporte_producto() {

        $sql = "SELECT 
                    id_producto, 
                    producto.nombre as nombre,
                    concentracion,
                    adicional,
                    precio,
                    laboratorio.nombre as laboratorio,
                    tipo_producto.nombre as tipo,
                    presentacion.nombre as presentacion,
                    producto.avatar as avatar,
                    prod_lab,
                    prod_tip_prod,
                    prod_present
                FROM producto
                JOIN laboratorio ON prod_lab = id_laboratorio
                JOIN tipo_producto ON prod_tip_prod = id_tip_prod
                JOIN presentacion ON prod_present = id_presentacion
                AND producto.nombre NOT LIKE ''
                ORDER BY producto.nombre";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute();

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;
            
        
    }
}