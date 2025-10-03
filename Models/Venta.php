<?php 

include_once "Conexion.php";

class Venta {

    var $objetos;

    public function __construct() {

        $db = new Conexion();

        $this -> acceso = $db -> pdo;

    }

    function crear($nombre, $dni, $total, $fecha, $vendendor) {

        $sql = "INSERT INTO venta (fecha, cliente, dni, total, vendedor)
                VALUES (:fecha, :cliente, :dni, :total, :vendedor)";
        
        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":fecha" => $fecha, 
                            ":cliente" => $nombre, 
                            ":dni" => $dni, 
                            ":total" => $total, 
                            ":vendedor" => $vendendor
                        ));
        
    }

    function ultima_venta() {

        $sql = "SELECT MAX(id_venta) as ultima_venta 
                FROM venta";
        
        $query = $this -> acceso -> prepare($sql);

        $query -> execute();

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

    function borrar($id_venta) {

        $sql = "DELETE FROM venta WHERE id_venta = :id_venta";

        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id_venta" => $id_venta));

    }

    function buscar() {

        $sql = "SELECT id_venta, fecha, cliente, dni, total, CONCAT(usuario.nombre_us, ' ', usuario.apellidos_us) AS vendedor 
                FROM venta 
                JOIN usuario ON vendedor = id_usuario";
        
        $query = $this -> acceso -> prepare($sql);

        $query -> execute();

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

    function venta_dia_vendedor($id_usuario) {

        $sql = "SELECT SUM(total) AS venta_dia_vendedor
                FROM venta
                WHERE vendedor = :id_usuario 
                AND date(fecha) = date(curdate())"; 
                
        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id_usuario" => $id_usuario));

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

    function venta_diaria() {

        $sql = "SELECT SUM(total) AS venta_diaria
                FROM venta
                WHERE date(fecha) = date(curdate())"; 
                
        $query = $this -> acceso -> prepare($sql);

        $query -> execute();

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

    function venta_mensual() {

        $sql = "SELECT SUM(total) AS venta_mensual
                FROM venta
                WHERE year(fecha) = year(curdate())
                AND month(fecha) = month(curdate())"; 
                
        $query = $this -> acceso -> prepare($sql);

        $query -> execute();

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

    function venta_anual() {

        $sql = "SELECT SUM(total) AS venta_anual
                FROM venta
                WHERE year(fecha) = year(curdate())"; 
                
        $query = $this -> acceso -> prepare($sql);

        $query -> execute();

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

    function buscar_id($id_venta) {

        $sql = "SELECT id_venta, fecha, cliente, dni, total, CONCAT(usuario.nombre_us, ' ', usuario.apellidos_us) AS vendedor 
                FROM venta 
                JOIN usuario ON vendedor = id_usuario
                AND id_venta = :id_venta";
        
        $query = $this -> acceso -> prepare($sql);

        $query -> execute(array(":id_venta" => $id_venta));

        $this -> objetos = $query -> fetchAll();

        return $this -> objetos;

    }

}