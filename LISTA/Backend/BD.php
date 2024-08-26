<?php
    class conexion{
        private $servidor = "localhost";
        private $usuario = "root";
        private $contrasena = "";
        private $conexion;

        public function __construct(){
            try {
                $this->conexion = new PDO("mysql:host=$this->servidor; dbname=qr", $this->usuario, $this->contrasena);
                $this->conexion -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $error) {
                return "Error al conectar con la base de datos.".$error;
            }
        }

        public function ejecutar($sql){
            $consulta=$this->conexion->prepare($sql);
            $consulta->execute();
            return $consulta;
        }
    }
?>