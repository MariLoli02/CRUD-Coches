<?php
    namespace App;
    
    require dirname(__DIR__, 1)."/vendor/autoload.php";

    use Faker\Factory;
use PDO;
use PDOException;

    

    class Autos extends Conexion{
        protected $id;
        protected $modelo;
        protected $tipo;
        protected $matricula;
        protected $marca_id;

        public function __constructor(){
            parent::__construct();
        }

        //----------------CRUD----------------
        public function create(){
            $q = "insert into autos(id, modelo, tipo, matrícula, marca_id) value(:i, :m, :t, :ma, :mi)";
            $stmt = parent::$conexion->prepare($q);
            try{    
                $stmt->execute([
                    ':i'=>$this->id,
                    ':m'=>$this->modelo,
                    ':t'=>$this->tipo,
                    ':ma'=>$this->matricula,
                    ':mi'=>$this->marca_id
                ]);

            }catch(PDOException $ex){
                die("Error al crear autos: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }

        public function read($id){
            $q="select * from autos where id=:i";
            $stmt= parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al leer auto: ".$ex->getMessage());
            }
            parent::$conexion=null;

            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function update($id){
            $q="update autos set modelo=:m, tipo=:t, matrícula=:ma, marca_id=:mi where id=:i";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':m'=>$this->modelo,
                    ':t'=>$this->tipo,
                    ':ma'=>$this->matricula,
                    ':mi'=>$this->marca_id,
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al actualizar auto: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }

        public function delete($id){
            $q="delete from autos where id=:i";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':i'=>$id
                ]);
            }catch(PDOException $ex){
                die("Error al eliminar auto: ".$ex->getMessage());
            }
            parent::$conexion=null;
        }


        //----------------OTROS MÉTODOS----------------
        public function crearAutos($cant){
            $tiposArray = ['Diesel', 'Gasolina', 'Híbrido', 'Eléctrico', 'Gas'];
            if($this->existen_Autos()){
                return;
            }

            $faker = Factory::create('es_Es');
            $faker->addProvider(new \Faker\Provider\Fakecar($faker));
            $marcas = (new Marcas)->devolver_ids();

            for($i=0; $i<$cant; $i++){
                $modelo = $faker->vehicleModel();
                $tipo = ($faker->randomElement($tiposArray));
                $matricula = $faker->vehicleRegistration('[0-9]{4}[A-Z]{3}');
                $marca_id = ($faker->randomElement($marcas)->id);

                (new Autos)->setModelo($modelo)
                ->setTipo($tipo)
                ->setMatricula($matricula)
                ->setMarca_id($marca_id)
                ->create();
            }

        }

        public function existen_Autos(){
            $q = "select * from autos";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al comprobar si existen autos: ".$ex->getMessage());
            }
            parent::$conexion = null;
            return $stmt->rowCount();
        }
        

        public function readAll(){
            $q = "select * from autos";
            $stmt = parent::$conexion->prepare($q);
            try{
                $stmt->execute();
            }catch(PDOException $ex){
                die("Error al leer datos: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function existeMatricula($matricula, $id=null){
            if($id!=null){
                $q = "select * from autos where matrícula=:m and id!=$id";
            }else{
                $q = "select * from autos where matrícula=:m";
            }
            
            $stmt= parent::$conexion->prepare($q);
            try{
                $stmt->execute([
                    ':m'=>$matricula
                ]);
            }catch(PDOException $ex){
                die("Error al consultar si existe la matricula: ".$ex->getMessage());
            }
            parent::$conexion=null;
            return $stmt->rowCount();
        }

        


        //----------------SETTERS----------------

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
         * Set the value of modelo
         *
         * @return  self
         */ 
        public function setModelo($modelo)
        {
                $this->modelo = $modelo;

                return $this;
        }

         /**
         * Set the value of tipo
         *
         * @return  self
         */ 
        public function setTipo($tipo)
        {
                $this->tipo = $tipo;

                return $this;
        }


        /**
         * Set the value of matricula
         *
         * @return  self
         */ 
        public function setMatricula($matricula)
        {
                $this->matricula = $matricula;

                return $this;
        }

        /**
         * Set the value of marca_id
         *
         * @return  self
         */ 
        public function setMarca_id($marca_id)
        {
                $this->marca_id = $marca_id;

                return $this;
        }

       
    }