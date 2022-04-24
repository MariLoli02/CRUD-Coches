<?php

    namespace App;

use PDO;
use PDOException;

    class Conexion{
        protected static $conexion;

        public function __construct()
        {
            if(self::$conexion==null){
                self::crearConexion();
            }
        }

        private static function crearConexion(){
            $fichero = dirname(__DIR__, 1)."/.config";
            $opciones = parse_ini_file($fichero);

            $host = $opciones['host'];
            $user = $opciones['user'];
            $pass = $opciones['password'];
            $ddbb = $opciones['ddbb'];

            $dns = "mysql:host=$host;dbname=$ddbb;charset=utf8mb4";

            try{
                // solo en desarrollo la primera linea
                $options = [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION];
                self::$conexion= new PDO($dns, $user, $pass, $options);
            }catch(PDOException $ex){
                die("Error al crear la conexion: ".$ex->getMessage());
            }
        }   
    }

    (new Conexion);
?>