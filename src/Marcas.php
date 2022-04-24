<?php
    namespace App;

    use Faker\Factory;
    use Faker\Provider;
use PDO;
use PDOException;

    class Marcas extends Conexion{
        protected $id;
        protected $nombre;
        protected $pais;

        public function __construct(){
            parent::__construct();
        }

        //----------------------------CRUD-----------------------------------

        public function create(){
            $q="insert into marcas(id, nombre, pais) value(:i, :n, :p)";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$this->id,
                    ':n'=>$this->nombre,
                    ':p'=>$this->pais
                ]);
            }catch(PDOException $ex){
                die("Error al insertar datos: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }

        public function read($id){
            $q="select * from marcas where id=:i";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al leer datos: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function update($id){
            $q="update marcas set nombre=:n, pais=:p where id=:i";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':n'=>$this->nombre,
                    ':p'=>$this->pais,
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al actualizar marca: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }

        public function delete($id){
            $q="delete from marcas where id=:i";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al borrar datos: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }

        //-------------------------OTROS MÉTODOS-----------------------------
        public function crearMarcas($cant){
            if($this->existenMarcas()){
                return;
            }

            $faker = Factory::create('es_ES');
            $faker->addProvider(new \Faker\Provider\Fakecar($faker));

            for($i=0; $i<$cant; $i++){
                $nombre = $faker->unique()->vehicleBrand();
                $pais = $faker->country();
    
                (new Marcas)->setNombre($nombre)
                ->setPais($pais)
                ->create();
            }

        }

        public function existenMarcas():bool{
            $q= "select * from marcas";
            $stmt= parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al comprobar si existen marcas: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->rowCount();
        }

        public function readAll(){
            $q="select * from marcas";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al leer marcas: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function existeNombre($nombre, $id=null):bool{
            if($id){
                $q="select * from marcas where nombre=:n and id!=$id";
            }else{
                $q="select * from marcas where nombre=:n";
            }
            $stmt=parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    'n'=>$nombre
                ]);
            }catch(PDOException $ex){
                die("Error al comprobar si existe el titulo");
            }
            parent::$conexion=null;
            return $stmt->rowCount();
        }

        public function devolver_ids(){
            $q = "select id from marcas";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al devolver las ids: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        //-------------------------SETTERS-----------------------------------

        /**
         * Set the value of id
         *
         * @return  self
         */ 
        public function setId($id)
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Set the value of nombre
         *
         * @return  self
         */ 
        public function setNombre($nombre)
        {
                $this->nombre = $nombre;

                return $this;
        }

        /**
         * Set the value of pais
         *
         * @return  self
         */ 
        public function setPais($pais)
        {
                $this->pais = $pais;

                return $this;
        }
    }