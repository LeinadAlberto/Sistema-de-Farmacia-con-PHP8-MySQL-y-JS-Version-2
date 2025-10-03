<?php 

    class Conexion {

        private $db = "farmaciasistemav2";      // Nombre de la Base de Datos
        private $servidor = "localhost";        // Nombre del servidor 
        private $puerto = "3306";               // Número de Puerto 
        private $charset = "utf8";              // Set de caracteres
        
        private $usuario = "root";              // Nombre del Usuario
        private $contrasena = "";               // Contraseña del Usuario

        private $atributos = [
            PDO::ATTR_CASE => PDO::CASE_LOWER, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];

        public $pdo = null;
        
        function __construct() {

            $this -> pdo = new PDO("mysql:dbname={$this -> db};
                                    host={$this -> servidor};
                                    port={$this -> puerto};
                                    charset={$this -> charset}",
                                $this -> usuario,
                                $this -> contrasena,
                                $this -> atributos
                            );

        }

    }


?>